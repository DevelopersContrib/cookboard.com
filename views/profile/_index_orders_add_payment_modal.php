<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div id="orders-add-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Pay On Delivery Payment</h4>
        </div>
        <div class="modal-body">
            <?php $form = ActiveForm::begin(['id'=>'order_add_payment_form','method' => 'post','action' => ['orders/ajax'],'class'=>"form-horizontal"]);?>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">Amount</span>
                <input id="payable-amount" type="text" name="amount" class="form-control" disabled placeholder="0.00">
                <input type="hidden" name="orders_add_payment_id" id="orders_add_payment_id" value="" />
                <?//= Html::activeHiddenInput($order, 'id')?>
                <?//= Html::activeHiddenInput($order, 'payment_status')?>
                <input type="hidden" name="action" value="paypod" />
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="submit-payment" data-loading-text="Saving..." type="button" class="btn btn-warning">Submit</button>
        </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_orders_payment_modal.js',['depends' => 'yii\web\AssetBundle'] );
