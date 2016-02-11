<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; // load classes

$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);

$this->registerCss('
    .dropzone .dz-default.dz-message span {
        display: block;
    }
    
    #establishments-modal .dropzone .dz-preview .dz-details, 
    #establishments-modal .dropzone-previews .dz-preview .dz-details {
        height: 300px;
        width: 300px;
    }
    
    #establishments-modal .dropzone .dz-preview .dz-details img, 
    #establishments-modal .dropzone-previews .dz-preview .dz-details img {
        height: 300px;
        width: 300px;
    }
    #my-dropzone-establishment{
        text-align: center;
    }
    
    #establishments-modal .dropzone .dz-preview .dz-progress, 
    #establishments-modal .dropzone-previews .dz-preview .dz-progress {
        top: auto;
    }

    #establishments-modal .dropzone .dz-default.dz-message {
        background-image: none;
        height: 100%;
        width: 100%;
        z-index: 9999999;
        top: 1px;
        left: 1px;
        margin-left: 0;
        margin-top: 0;
    }
    #establishments-modal .dropzone.dz-started .dz-message {
        opacity: 1;
    }
}');
?>
<div id="establishments-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Establishment</h4>
        </div>
        <div class="modal-body">
            <center><img src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/cook-loading.gif"><br>Loading...</center>
            <?php $form = ActiveForm::begin(['id'=>'new-establishment','method' => 'post',
                    'action'=>['establishment/ajax'],]);?>
                
                <?= $form->field($establishments_model, 'name',
                    ['template'=>'Name<span class="sr-only control-label">Name</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                
                <?=$form->field($establishments_model, 'type',
                    ['template'=>'Type<span class="sr-only">Type</span>{input}{hint}{error}'])
                    ->dropDownList($establishments_model->typeList, ['class'=>'form-control','prompt'=>'Select Type']) ?>
                
                <?= $form->field($establishments_model, 'location',
                    ['template'=>'Location<span class="sr-only control-label">Location</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                
                <?/*= $form->field($establishments_model, 'rating',
                    ['template'=>'Rating<span class="sr-only control-label">Rating</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control user-input']) */?>
                
                <?=$form->field($establishments_model, 'rating',
                    ['template'=>'Rating<span class="sr-only">Type</span>{input}{hint}{error}'])
                    ->dropDownList(["1"=>1,"2"=>2,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"10"=>10], ['class'=>'form-control']) ?>
                
                <?= $form->field($establishments_model, 'review',
                    ['template'=>'Review<span class="sr-only">Review</span>{input}{hint}{error}'])
                        ->textarea(['class'=>'form-control user-input','rows' => 5]) ?>
                
<!--                <input id="establishment-photo-url" namd="Establishments[photo]" type="hidden" value="" />-->
                <?= Html::activeHiddenInput($establishments_model, 'photo',['class'=>'user-input','id'=>'establishment-photo-url'])?>
                <?= Html::activeHiddenInput($establishments_model, 'id',['class'=>'user-input'])?>
                <input type="hidden" name="action" value="save" />
                <?php ActiveForm::end(); ?>
                Photo
                <form id="my-dropzone-establishment" class="form-inline dropzone dz-clickable" role="form">
                    <?=Yii::$app->z->hiddenCsrfToken()?>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-warning" type="button" data-loading-text="Saving..." id="save-establishment">Save</button>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_establishments_modal.js',['depends' => 'yii\web\AssetBundle'] );
