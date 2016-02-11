<div id="w0" class="grid-view">
    <h3>Board  Orders</h3><hr>
<table id="tbl-orders" class="display dataTable">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Buyer</th>
            <th>Payment</th>
            <th>Status</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($orders as $order){
    ?>
        <tr id='tr-<?=$order->id?>'>
                <td data-id='tr-<?=$order->id?>'><?=$order->id?></td>
                <td data-id='tr-<?=$order->id?>'><?=$order->datetime_created;?></td>
                <?php $u = $order->user?>
                <td><a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]);?>"><?=$u->username;?></a></td>
                <td><?=$order->getPaymentStatusText()?></td>
                <td><?=$order->getStatusText()?></td>
                
                <td><a data-id="<?=$order->id?>" class="view-orders" href="javascript:;">View Order</a></td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>
</div>
<script>
var gIndexOrders;
var gIndexOrdersModal;
var gIndexOrdersPaymentModal;
</script>
<?=$this->render('_index_orders_modal')?>
<?=$this->render('_index_orders_add_payment_modal')?>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_orders_add_payment_modal.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_orders.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('_index_orders_js.php'));
?>
