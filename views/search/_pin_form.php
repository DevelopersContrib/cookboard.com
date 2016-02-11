<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss('
.cb-new {
    display:none;
}
');
?>
<div class="modal fade pin-it-form" id="pinIt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <?php $form = ActiveForm::begin(['id'=>'pin-form','method' => 'post',
                    'action'=>['search/ajax'],]);?>
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Pick A Board</h4>
          </div>
          <div class="modal-body">
            <!-- -->
                <div class="row">
                    <div class="col-lg-8">          
                    <div class="form-group fcol">
                        <label for="inputEmail3" class="control-label">Board</label>
                          <select id="select-board" name="CookBoardPin[cook_board_id]" class="form-control">
                            <?php
                                foreach($cookboardlist as $board){
                                    echo "<option value='".$board->id."'>".$board->name."</option>";
                                }
                            ?>
                            <option value="-1">(Add New Cookboard)</option>
                            </select>
                      </div>			  
                      
                        <?= $form->field($cookboard, 'name',
                            ['template'=>'{label}<span class="sr-only control-label">Name</span>{input}{hint}{error}','options' => ['class' => 'fcol cb-new ']])
                            ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>

                        <?= $form->field($cookboard, 'description',
                        ['template'=>'{label}<span class="sr-only">Description</span>{input}{hint}{error}','options' => ['class' => 'fcol cb-new ']])
                            ->textarea(['class'=>'form-control user-input','rows' => 5]) ?>
                            
                      <?php
                    if(Yii::$app->user->identity->type==\app\models\UserModel::PREMIUM){
                ?>
                        <div class="form-group fcol cb-new">                            
                            <?=Html::activeRadioList($cookboard, 'featured', [1 => 'Featured', 0 => 'Not Featured'], [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<label class="radio-inline">' . 
                                        Html::radio($name, $checked, ['value'  => $value,'id'=>'featured'.$value]) . $label . '</label>';
                                }
                            ])?>
                         <?php }?>
                        <hr>
                <?= $form->field($cookboard, 'facebook',
                    ['template'=>'Facebook<span class="sr-only control-label">Facebook</span>{input}{hint}{error}','options' => ['class' => 'fcol cb-new ']])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                
                <?= $form->field($cookboard, 'instagram',
                    ['template'=>'Instagram<span class="sr-only control-label">Instagram</span>{input}{hint}{error}','options' => ['class' => 'fcol cb-new ']])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                
                <?= $form->field($cookboard, 'pinterest',
                    ['template'=>'Pinterest<span class="sr-only control-label">Pinterest</span>{input}{hint}{error}','options' => ['class' => 'fcol cb-new ']])
                    ->textInput(['class'=>'form-control user-input','maxlength' => 255]) ?>
                            <input type="hidden" name="action" value="save" />
                            <input id="be_id" name="CookBoardPin[board_entry_id]" type="hidden" value="" >
                        </div>
                </div>
                
                <div class="col-lg-4">
                    <img id="pin-pic" class="img-responsive" src="http://media-cache-ec0.pinimg.com/236x/47/9b/07/479b075b38b05bb78d18cf5f7e1e8ed0.jpg">
                </div>
                </div>
                <!-- -->
                <div style="clear:both"></div>
          </div>
          <div class="modal-footer footbg">
                    <!--<label class="pull-left ptf"><input type="checkbox"> Post To Facebook</label>-->
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="submit-pin" type="button" class="btn btn-warning">Pin It!</button>
          </div>
		  <div style="clear:both"></div>
        </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>

<?php $this->registerJsFile(Yii::$app->homeUrl.'js/search/_pin_form.js',['depends' => 'yii\web\AssetBundle'] );?>
<style>
.modal-content {
	box-shadow:none;
	border-radius: 6px 6px 0px 0px;
	border: none;
	padding-bottom: 20px;
}
.footbg {
	background:#ffffff;
	border-radius: 0px 0px 6px 6px;
}
</style>