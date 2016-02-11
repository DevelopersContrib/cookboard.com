<div id="w0" class="grid-view">
    <h3>Entry Payments</h3><hr>
<table id="tbl-my-payments" class="display dataTable">
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
        foreach($my_payments as $payment){
    ?>
        <tr id='tr-<?=$payment->id?>'>
            <td data-id='tr-<?=$payment->id?>'><?=$payment->datetime_created;?></td>    
            <td data-id='tr-<?=$payment->order->id?>'><?=$payment->order->id?></td>
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
var gIndexMyPayments;
var gIndexMyPaymentsModal;
</script>
<?=$this->render('_index_my_payments_modal')?>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_my_payments.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('_index_my_payments_js.php'));
?>
