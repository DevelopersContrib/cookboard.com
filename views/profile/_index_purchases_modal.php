<div id="purchases-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">View Purchase</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button id="update-purchase" style="display:none;" data-loading-text="Saving..." type="button" class="btn btn-warning">Update Purchase</button>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_purchases_modal.js',['depends' => 'yii\web\AssetBundle'] );
?>