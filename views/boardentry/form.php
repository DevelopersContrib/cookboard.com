<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\ValidationAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->isNewRecord ? "Create Board Entry" : "Update Board Entry";

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
            <?php $form = ActiveForm::begin(['id'=>'entry_form','method' => 'post','action' => ['boardentry/save'],]);?>    
            <?= Html::activeHiddenInput($model, 'cook_board_id')?>
            <?= Html::activeHiddenInput($model, 'id')?>
            <div class="col-lg-12">
            <?= $form->field($model, 'name',['template'=>'<span class="sr-only control-label">Food Title</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'Title']) ?>
            </div>
            <div class="col-lg-4">                
                <?=$form->field($model, 'cuisine_id',
                    ['template'=>'<span class="sr-only">Cuisine</span>{input}{hint}{error}'])
                    ->dropDownList($model->cuisineList, ['class'=>'form-control','prompt'=>'Select your Cuisine ']) ?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'course_id',
                    ['template'=>'<span class="sr-only">Course</span>{input}{hint}{error}'])
                    ->dropDownList($model->courseList, ['class'=>'form-control','prompt'=>'Select your course']) ?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'diet_id',
                    ['template'=>'<span class="sr-only">Diet</span>{input}{hint}{error}'])
                    ->dropDownList($model->dietList, ['class'=>'form-control','prompt'=>'Select your Diet']) ?>            
            </div>
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
                    ->textInput(['class'=>'form-control','maxlength' => 128,'placeholder'=>'City']) ?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'delivery_type_id',
                    ['template'=>'<span class="sr-only">Delivery Type</span>{input}{hint}{error}'])
                    ->dropDownList($model->deliveryTypeList, ['class'=>'form-control','prompt'=>'Select type of delivery']) ?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'price_type_id',
                    ['template'=>'<span class="sr-only">Type of price</span>{input}{hint}{error}'])
                    ->dropDownList($model->priceTypeList, ['class'=>'form-control','prompt'=>'Type of price']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'price',['template'=>'<span class="sr-only">Price</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control','placeholder'=>'Price']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
            <div class="col-lg-12">
                <h2>Upload Picture</h2>
            </div>
            <?php foreach($model->boardEntryPhoto as $item){
                ?>
                <div class="col-lg-3">
                    <img class="img-responsive" src="<?=Yii::$app->homeUrl.$item->photo?>" />
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
                <?php /*
                use dosamigos\fileupload\FileUploadUI;
                ?>
                <?php echo FileUploadUI::widget([
                    'model' => $photo,
                    'attribute' => 'photo',
                    'url' => ['boardentry/upload', 'id' => $photo->id],
                    'gallery' => false,
                    'fieldOptions' => [
                        'accept' => 'image/*'
                    ],
                    'clientOptions' => [
                        'maxFileSize' => 2000000
                    ]
                ]);*/
                ?>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <div id="dropzone">
                        <form id="my-dropzone" action="<?=Yii::$app->urlManager->createUrl(['boardentry/upload']);?>" class="dropzone dz-clickable">
                            <?=Yii::$app->z->hiddenCsrfToken()?>
                        </form> 
                    </div>
                </div>
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
                    <a href="<?=Yii::$app->urlManager->createUrl(['cookboard/details', 'id' => $model->cook_board_id]);?>" class="btn btn-info btn-block btn-lg">
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
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/boardentry/_form_boardentry.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/dropzone.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('form_js.php')); ?>
