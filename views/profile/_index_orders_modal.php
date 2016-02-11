<div id="orders-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">View Orders</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button id="create-payment" style="display:none;" data-loading-text="Saving..." type="button" class="btn btn-danger">Create POD Payment</button>
                <button id="update-order" data-loading-text="Saving..." type="button" class="btn btn-warning">Update Order</button>
            </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_orders_modal.js',['depends' => 'yii\web\AssetBundle'] );
