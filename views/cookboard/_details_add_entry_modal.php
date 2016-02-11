<div id="details-add-entry-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Select Entry Type</h4>
        </div>
        <div class="modal-body">
            <center>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" checked="" name="inlineRadioOptions" id="forsale" value="option1"> For Sale Entry
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="poststatus" value="option2"> Post Status Entry
                    </label>
                </div>
            </center>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a id="continue-create-entry" href="javascript:;" class="btn btn-warning">Continue</a>
            <a style="display:none" id="continue-create-entry1" href="javascript:;" class="btn btn-warning">Continue</a>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/_details_add_entry_modal.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs(
"
    gDetailsAddEntryModal = Object.create(Cookboard.DetailsAddEntryModal);
    gDetailsAddEntryModal.createUrl = '".Yii::$app->urlManager->createUrl(['boardentry/create'])."';
    gDetailsAddEntryModal.postUrl = '".Yii::$app->urlManager->createUrl(['boardentry/post'])."'
    gDetailsAddEntryModal.init('details-add-entry-modal');
    
");
