<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\ValidationAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/select2.css",['depends' => 'app\assets\AppAsset']);
$this->title = $model->isNewRecord ? "Create Post Entry" : "Update Post Entry";

$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    $this->title,
];
?>
<style>
    .fileupload-buttonbar .delete, .fileupload-buttonbar input[type='checkbox']{
        display:none;
    }
    .preview img{
        width:200px;
        height: 200px;
    }
    .ui-autocomplete-loading {
        background: white url("<?=Yii::$app->homeUrl.'img/ui-anim_basic_16x16.gif';?>") right center no-repeat;
    }
    .ui-autocomplete{
        z-index: 9999999;
    }
	.select2-container-multi .select2-choices {
		border-radius: 4px;
	}
</style>

<div class="row">
<div class="col-lg-12">
    <br>
    <h1 class="font-raleways font-300"><?=$this->title?></h1>
    <br>
</div>
<div class="col-lg-12">    
    <div class="wrap-addFood-container font-raleways">
        
        <h2>Basics</h2>
        <p>All fields are required.</p>
        
        <div class="row">
            <?php $form = ActiveForm::begin(['id'=>'entry_form','method' => 'post','action' => ['boardentry/savepost'],]);?>    
            <?= Html::activeHiddenInput($model, 'cook_board_id')?>
            <?= Html::activeHiddenInput($model, 'id')?>
            <?= Html::activeHiddenInput($model, 'post_type')?>
            <?= Html::activeHiddenInput($model, 'latlng',['class'=>'boardentry-latlng'])?>
            <div class="col-lg-12">
            <?= $form->field($model, 'name',['template'=>'<span class="sr-only control-label">Food Title</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control boardentry-name','maxlength' => 255,'placeholder'=>'Title']) ?>
            </div>
			<?php if(!empty($model->id)){ ?>
            <div class="col-lg-4">                
                <?=$form->field($model, 'cuisine_id',
                    ['template'=>'<span class="sr-only">Cuisine</span>{input}{hint}{error}'])
                    ->dropDownList($model->cuisineList, ['class'=>'form-control','prompt'=>'Select your Cuisine ']) ?>
            </div>
			<?php }?>
            <div class="col-lg-4">
                <?=$form->field($model, 'course_id',
                    ['template'=>'<span class="sr-only">Course</span>{input}{hint}{error}'])
                    ->dropDownList($model->courseList, ['class'=>'form-control','prompt'=>'Select your course']) ?>
            </div>
			<?php if(!empty($model->id)){ ?>
            <div class="col-lg-4">
                <?=$form->field($model, 'diet_id',
                    ['template'=>'<span class="sr-only">Diet</span>{input}{hint}{error}'])
                    ->dropDownList($model->dietList, ['class'=>'form-control','prompt'=>'Select your Diet']) ?>            
            </div>
			<?php }?>
            <div class="col-lg-12">
                <h2>Description</h2>
                <?= $form->field($model, 'description',['template'=>'<span class="sr-only">Food Description</span>{input}{hint}{error}'])
                    ->textarea(['class'=>'form-control','rows' => 6,'placeholder'=>'Food description']) ?>
            </div>
            <div class="col-lg-12">
                <h2>Location</h2>
            </div>
            <div class="col-lg-12">
                <?= $form->field($model, 'city',['template'=>'<span class="sr-only">City</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control boardentry-city','maxlength' => 128,'placeholder'=>'City']) ?>
            </div>
            
            <div class="col-lg-12">
                <div id="boar-entry-map" style="width:100%; height:200px;"></div>
                <br>
            </div>
            
            <?php
                if(count($establishments)>0){
            ?>
            <div class="col-lg-12">
                <div class="form-group">
                    <span class="sr-only">Estrablishments</span>
                        <select name="" style="width: 100%;" class="populate select2-offscreen" id="establishments" multiple="" tabindex="-1">
                        <?php
                            foreach($establishments as $item){
                        ?>
                        <option value="<?=$item->id?>"><?=$item->name;?></option>
                        <?php
                            }
                        ?> 
                        </select>
                    <div class="help-block"></div>
                </div>
            </div>
            <?php }?>
            <input id="establishments_ids" type="hidden" value="" name="establishments_ids" />
            
            <?php ActiveForm::end(); ?>
            <div class="col-lg-12">
                <h2>Upload Picture</h2>
            </div>
            <?php foreach($model->boardEntryPhoto as $item){
                ?>
                <div class="col-lg-3">
                    <img class="img-responsive" src="<?=$item->external?$item->photo:Yii::$app->homeUrl.$item->photo?>" />
                    <br>
                    <div class="form-group">
                        <input id="<?=$item->id?>" class="old-pic-title form-control input-sm" value="<?=$item->title?>" placeholder="Title..."/>
                    </div>
                    <div class="form-group">
                        <textarea id="<?=$item->id?>" class="old-pic-desc form-control input-sm" placeholder="Description..."><?=$item->description?></textarea>
                    </div>
                    <div class="form-group">
                        <a id="<?=$item->id?>" data-title="<?=$item->title?>" href="javascript:;" class="btn btn-primary btn-sm remove-pic">Remove</a>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div id="inputFormUpload">
                        <label class="radio-inline">
                          <input class='uploadOptions' type="radio" name="uploadOptions" value="#browseUpload"> Browse Upload
                        </label>
                        <label class="radio-inline">
                          <input class='uploadOptions' type="radio" name="uploadOptions" value="#urlUpload"> URL Upload
                        </label>
                    </div>
                </div>
            </div>
            <div id="browseUpload" class="col-lg-12 up" style="display:none;">
                <div class="form-group">
                    <div id="dropzone">
                        <form id="my-dropzone" action="<?=Yii::$app->urlManager->createUrl(['boardentry/upload']);?>" class="dropzone dz-clickable">
                            <?=Yii::$app->z->hiddenCsrfToken()?>
                        </form> 
                    </div>
                </div>
            </div>
            <div id="urlUpload" class="col-lg-12 up" style="display:none;">
                <div class="row link-container">
                    <form id="frm-url" class="frm-url">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <a class="link-remove btn btn-danger btn-sm remove-pic" href="javascript:;" style="display:none;"><i class="fa fa-close"></i> Remove</a>
                            </div>
                            <div class="form-group link-url-container">
                                <label class="sr-only">URL Upload</label>
                                <input id="link-url" name='link-url[]' type="text" class="form-control link-url" placeholder="URL Upload">
                                <div class="help-block"></div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Title</label>
                                <input name='link-title[]' type="text" class="form-control link-title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Description</label>
                                <textarea name='link-description[]' class="form-control link-description" placeholder="Description"></textarea>
                            </div>
                            <hr>
                        </div>
                    </form>
                </div>
                <a id="add-link" class="btn btn-primary btn-sm" href="javascript:;"><i class="fa fa-folder-o"></i> Add Link</a>
                <br><br>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <a id="submit_entry" href="javascript:;" class="btn btn-warning btn-block btn-lg">
                        <i class="fa fa-check"></i> Submit
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <a href="<?=Yii::$app->urlManager->createUrl(['cookboard/details', 'slug' => $model->cookboard->slug]);?>" class="btn btn-info btn-block btn-lg">
                        <i class="fa fa-check"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    var gFormBoardEntry;
</script>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/boardentry/_form_boardentry.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/dropzone.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/select2.js',['depends' => 'yii\web\AssetBundle'] );
?>
<?php $this->registerJs($this->render('form_js.php',['model'=>$model,'postimg'=>$postimg])); ?>
