<div id="w0" class="grid-view">
    <h3>Entry Purchases</h3><hr>
<table id="tbl-purchases" class="display dataTable">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Seller</th>
            <th>Payment</th>
            <th>Status</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($purchases as $purchase){
    ?>
            <tr id='tr-<?=$purchase->id?>'>
            <td data-id='tr-<?=$purchase->id?>'><?=$purchase->id?></td>
            <td data-id='tr-<?=$purchase->id?>'><?=$purchase->datetime_created;?></td>

            <?php $u = $purchase->seller;?>
            <td><a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]);?>"><?=$u->username;?></a></td>
             <td><?=$purchase->getPaymentStatusText()?></td>
            <td><?=$purchase->getStatusText()?></td>
            <td><a data-id="<?=$purchase->id?>" class="view-purchases" href="javascript:;">View</a></td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>
</div>
<script>
var gIndexPurchases;
var gIndexPurchasesModal;
</script>
<?=$this->render('_index_purchases_modal')?>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_purchases.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('_index_purchases_js.php'));
?>
