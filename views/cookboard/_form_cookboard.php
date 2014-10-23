<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!-- Modal -->
<div class="modal fade" id="form_cookboard" tabindex="-1" role="dialog" aria-labelledby="form_cookboardLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="form_cookboardLabel">Cookboard Information</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id'=>'form','method' => 'post',
                    'action'=>['cookboard/ajax'],]);?>
                
                <?= $form->field($cookboard, 'name',
                    ['template'=>'Board name<span class="sr-only control-label">Name</span>{input}{hint}{error}'])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                
                <?= $form->field($cookboard, 'description',
                    ['template'=>'Description<span class="sr-only">Description</span>{input}{hint}{error}'])
                        ->textarea(['class'=>'form-control user-input','rows' => 5]) ?>
                
                <?=Html::activeRadioList($cookboard, 'featured', [1 => 'Featured', 0 => 'Not Featured'], [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return '<label class="radio-inline">' . 
                            Html::radio($name, $checked, ['value'  => $value,'id'=>'featured'.$value]) . $label . '</label>';
                    }
                ])?>
                <?= Html::activeHiddenInput($cookboard, 'id',['class'=>'user-input'])?>
                <input type="hidden" name="action" value="save" />
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id='submit_cookboard' data-loading-text="Saving..." type="button" class="btn btn-primary">Submit</button>
            </div>
            
        </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/_form_cookboard.js',['depends' => 'yii\web\AssetBundle'] ); ?>