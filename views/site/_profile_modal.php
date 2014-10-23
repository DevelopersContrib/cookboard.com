
<div class="modal fade pro-settings" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="update-profile" data-loading-text="Saving..." type="button" class="btn btn-warning">Save Profile</button>
            </div>
          </div>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/site/_profile_modal.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs("
    gProfileModal = Object.create(Cookboard.ProfileModal);
    gProfileModal.baseUrl = '".Yii::$app->homeUrl."';
    gProfileModal.init('profileModal');"
); ?>