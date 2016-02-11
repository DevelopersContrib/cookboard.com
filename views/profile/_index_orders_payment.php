<div id="w0" class="grid-view">
    <h3>Received Payments</h3><hr>
<table id="tbl-orders-payment" class="display dataTable">
    <thead>
        <tr>
            <th>Date</th>
            <th>Order #</th>
            <th>Amount</th>
            <th>Payment Type</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($orders_payment as $payment){
    ?>
        <tr id='tr-<?=$payment->id?>'>
            <td data-id='tr-<?=$payment->id?>'><?=$payment->datetime_created;?></td>    
            <td data-id='tr-<?=$payment->id?>'><?=$payment->id?></td>
            <td><?=number_format($payment->amount,2)?></td>
            <td><?=$payment->getPaymentTypeText()?></td>
            <td><a data-id="<?=$payment->id?>" class="view-orders-payment" href="javascript:;">View Payment</a></td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>
</div>
<script>
var gIndexOrdersPayment;
var gIndexOrdersPaymentModal;
</script>
<?=$this->render('_index_orders_payment_modal')?>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_orders_payment.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('_index_orders_payment_js.php'));
?>
