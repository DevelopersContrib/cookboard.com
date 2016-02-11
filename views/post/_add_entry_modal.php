<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCss('
.cb-new {
    display:none;
}
');
?>
<div id="add-entry-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Post</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <label for="inputEmail3" class="control-label">Entry Type</label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" checked="" name="inlineRadioOptions" id="forsale" value="option1"> For Sale Entry
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="poststatus" value="option2"> Post Status Entry
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-12">          
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
                           <form id="post-form" method="post" action="">
                               <?='<input type="hidden" name="_csrf" value="'.Yii::$app->request->getCsrfToken().'">'?>
                                <div class="fcol cb-new  field-cookboard-name required" style="">
                                <label for="cookboard-name" class="control-label">Name</label><span class="sr-only control-label">Name</span>
                                <input type="text" maxlength="255" name="CookBoard[name]" class="form-control user-input" id="cookboard-name"><div class="help-block"></div>
                                </div>

                                <div class="fcol cb-new  field-cookboard-description required" style="">
                                <label for="cookboard-description" class="control-label">Description</label><span class="sr-only">Description</span><textarea rows="5" name="CookBoard[description]" class="form-control user-input" id="cookboard-description"></textarea><div class="help-block"></div>
                                </div>
                            <?php
                    if(Yii::$app->user->identity->type==\app\models\UserModel::PREMIUM){
                ?>
                                <div class="form-group fcol cb-new">                            
                                    <div id="cookboard-featured">
                                        <label class="radio-inline">
                                            <input type="radio" value="1" name="CookBoard[featured]" id="featured1">Featured</label>
                                        <label class="radio-inline"><input type="radio" checked="" value="0" name="CookBoard[featured]" id="featured0">Not Featured</label>
                                    </div>

                                    <input type="hidden" name="action" value="save" />
                                    <input id="be_id" name="CookBoardPin[board_entry_id]" type="hidden" value="" >

                                </div>
                               <?php }?>
                                <hr> 
                                <div class="form-group field-cookboard-facebook cb-new" >
                                Facebook
                                <span class="sr-only control-label">Facebook</span>
                                <input id="cookboard-facebook" class="form-control user-input" type="text" maxlength="255" name="CookBoard[facebook]">
                                <div class="help-block"></div>
                                </div>
                                <div class="form-group field-cookboard-instagram cb-new">
                                Instagram
                                <span class="sr-only control-label">Instagram</span>
                                <input id="cookboard-instagram" class="form-control user-input" type="text" maxlength="255" name="CookBoard[instagram]">
                                <div class="help-block"></div>
                                </div>
                                <div class="form-group field-cookboard-pinterest cb-new">
                                Pinterest
                                <span class="sr-only control-label">Pinterest</span>
                                <input id="cookboard-pinterest" class="form-control user-input" type="text" maxlength="255" name="CookBoard[pinterest]">
                                <div class="help-block"></div>
                                </div>
                               
                               
                           </form>
                </div>
                
               
            </div>
            <div style="clear:both"></div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a id="submit-create-entry" href="javascript:;" class="btn btn-warning">Continue</a>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/post/_add_entry_modal.js',['depends' => 'app\assets\AppAsset'] );
$this->registerJs(
"
    gAddEntryModal = Object.create(Cookboard.AddEntryModal);
    gAddEntryModal.baseUrl = '".Yii::$app->homeUrl."';
    gAddEntryModal.createUrl = '".Yii::$app->urlManager->createUrl(['boardentry/create'])."';
    gAddEntryModal.postUrl = '".Yii::$app->urlManager->createUrl(['boardentry/post'])."';
    gAddEntryModal.init('add-entry-modal');
    
");
