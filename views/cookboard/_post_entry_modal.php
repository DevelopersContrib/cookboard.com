<style>
.select-source h3 {
	margin:0px;
}
.select-source .fa {
	font-size:60px;
}
.select-source a {
	margin:10px;
	border:1px solid #fff;
	width:120px;
}
.select-source a:hover {
	border:1px solid #333;
}
.list-group-item{
	border: medium none;
}
</style>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('
.cb-new {
    display:none;
}
/*#images1 img{
    width:200px;
    height:200px;
    padding:10px
}*/
');
?>
<div class="modal fade pro-settings" id="postEntryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Post Status</h4>
            </div>
            <div class="modal-body">
                <div id="panel-selectsource" >
                    <center>
                        <div class="select-source">
                            <a class="btn btn-warning" href="javascript:;" id="source-website">
							<i class="fa fa-globe"></i>
							<h3>Website</h3>
							</a>
                            <a class="btn btn-warning" href="javascript:;" id="source-device">
							<i class="fa fa-mobile"></i>
							<h3>Device</h3>
							</a>
                        </div>                    
                    </center>
                </div>
                <div id="panel-website" style="display: none;" class="panel">
                    <ul class="list-group">
                        <li class="list-group-item" id="panel-website-url">
							<div class="form-group">
								<div id="website-url-error" class="help-block" ></div>
								<div class="input-group">
								<input value="" id="source-url" name="source-url" type="text" class="form-control" placeholder="http://example.com" autocomplete="off" >
								<span class="input-group-btn">
								<button id="load-website" class="btn btn-default" type="button" data-loading-text="Loading...">Go!</button>
								</span>
								</div>
							</div>
                        </li>
                        <li class="list-group-item" id="panel-website-images" style="display:none">
                            <div id="images1" class="form-group">
                            </div>
                            <div class="clearfix"></div>
                        </li>
						<li class="list-group-item" style="display:none" id="panel-website-cookboard">
							<?php $form = ActiveForm::begin([ 'id'=>'frm-website','method' => 'post','action'=>['boardentry/ajax'],]);?>
								<div class="form-group fcol">
									<label>
									  Select Board
									</label>
									<span class="sr-only">Cookboard</span>
										<select autocomplete="off" id="select-board" name="CookBoard[cook_board_id]" class="form-control select-board">
										<?php
											foreach($cookboardlist as $board){
												$selected = $cookboard_id==$board->id?'SELECTED':'';
												echo "<option $selected value='".$board->id."'>".$board->name."</option>";
											}
										?>
										<option value="-1">(Add New Cookboard)</option>
										</select>
									<div class="help-block"></div>
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
							
							<?php ActiveForm::end(); ?>
						</li>
						<li class="list-group-item" style="display:none" id="panel-website-titledesc">
							<div class="fcol">
								<label for="link-title" class="control-label">Title</label>
								<span class="sr-only control-label">Title</span>
								<input type="text" maxlength="255" name="link-title" class="form-control" id="link-title">
							</div>
							<div class="fcol">
								<label for="link-description" class="control-label">Description</label>
								<span class="sr-only">Description</span>
								<textarea rows="5" name="link-description" class="form-control" id="link-description"></textarea>
							</div>
						</li>
                    </ul>    
                </div>
                <div id="panel-device" style="display: none;" class="panel">
                    <ul class="list-group">
                        <li id="panel-device-step1" class="list-group-item">
                        <label>
                          Upload Image
                        </label>
							<div class="form-group">
								<div id="dropzone">
									<form id="my-dropzone" action="<?=Yii::$app->urlManager->createUrl(['boardentry/upload']);?>" class="dropzone dz-clickable">
										<?=Yii::$app->z->hiddenCsrfToken()?>
									</form>
								</div>
							</div>
                        
                      </li>
						<li id="panel-device-step2" class="list-group-item" style="display:none">
							<?php $form = ActiveForm::begin([ 'id'=>'frm-device','method' => 'post','action'=>['boardentry/ajax'],]);?>
								<div class="form-group fcol">
									<label>
									  Select Board
									</label>
									<span class="sr-only">Cookboard</span>
										<select autocomplete="off" id="select-board" name="CookBoard[cook_board_id]" class="form-control select-board">
										<?php
											foreach($cookboardlist as $board){
												$selected = $cookboard_id==$board->id?'SELECTED':'';
												echo "<option $selected value='".$board->id."'>".$board->name."</option>";
											}
										?>
										<option value="-1">(Add New Cookboard)</option>
										</select>
									<div class="help-block"></div>
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
							
							<?php ActiveForm::end(); ?>
						</li>
                    </ul>

                </div> 
            </div>
            <div class="modal-footer">
                <button id="btn-back" data-target="" style="float:left;display: none;" type="button" class="btn btn-danger" >Back</button>
                <button id="continue" data-target="" style="display: none;" type="button" class="btn btn-warning" >Continue</button>
				
				
				<!--<button id="continue-website" style="display: none;" type="button" class="btn btn-warning" >Continue</button>
				<button id="continue-website-titledesc" style="display: none;" type="button" class="btn btn-warning" >Continue</button>-->
				<button id="submit-website" style="display: none;" data-loading-text="Saving..." type="button" class="btn btn-primary" >Post!</button>
				
                <button id="back-panel-device-step1" style="float:left;display: none;" type="button" class="btn btn-danger" >Back</button>
                <button id="continue1" data-loading-text="Uploading..."  style="display: none;" type="button" class="btn btn-warning" >Continue</button>
                <button id="submit-post" style="display: none;" data-loading-text="Saving..." type="button" class="btn btn-primary" >Post!</button>
            </div>
          </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/dropzone.js',['depends' => 'app\assets\AppAsset'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/_postentry_modal.js',['depends' => 'app\assets\AppAsset'] ); ?>
<?php $this->registerJs("
    gPostEntryModal = Object.create(Cookboard.PostEntryModal);
    gPostEntryModal.baseUrl = '".Yii::$app->homeUrl."';
	gPostEntryModal.uploadUrl = '".Yii::$app->urlManager->createUrl(['boardentry/upload'])."';
    gPostEntryModal.init('postEntryModal');"
); ?>