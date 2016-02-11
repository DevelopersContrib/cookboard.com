<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $u = $order->user;
    
    if($order->payment_status === \app\models\Orders::UNPAID){
?>
<style>
    #create-payment{
        display:inline !important;
    }
</style>
<?php 
    }
    $form = ActiveForm::begin(['id'=>'order_form','method' => 'post','action' => ['orders/ajax'],'class'=>"form-horizontal"]);?>
    <div class="row show-grid">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label">Order #</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><?=$order->id?></p>
                </div>
                <?= Html::activeHiddenInput($order, 'id')?>
                <input type="hidden" name="action" value="save" />
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Date</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=date("m/d/Y", strtotime($order->datetime_created));?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Buyer</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]);?>"><?=$u->username;?></a></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Notes</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><?=$order->notes?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label">Payment</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=$order->getPaymentStatusText()?></p>
                  <?/*=$form->field($order, 'payment_status',
                    ['template'=>'<span class="sr-only">Course</span>{input}{hint}{error}'])
                    ->dropDownList([
                        app\models\Orders::UNPAID =>'Unpaid', 
                        app\models\Orders::PAID=>'Paid',],
                        ['class'=>'form-control']) */?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                    <?=$form->field($order, 'status',
                    ['template'=>'<span class="sr-only">Course</span>{input}{hint}{error}'])
                    ->dropDownList([
                        app\models\Orders::STATUS_PENDING =>'Pending', 
                        app\models\Orders::STATUS_DELIVERED=>'Delivered',],
                        ['class'=>'form-control']) ?>
                </div>
            </div>
            
        </div>
    </div>
<?php ActiveForm::end(); ?>
<hr>
<table id="tbl-orders-items" class="display dataTable">
    <thead>
        <tr>
            <th>Date</th>
            <th>Entry</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totals = 0;
        foreach($order->ordersItem as $item){
        ?>
        <tr>
            <td><?=$item->orders->datetime_created;?></td>
            <td><?=$item->boardEntry->name;?></td>
            <td><?=$item->price;?></td>
            <td><?=$item->qty;?></td>
            <td><?=number_format($item->total,2);?></td>
        </tr>
        <?php
            $totals = $totals+$item->total;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td><strong>Totals:</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><?=number_format($totals,2);?></strong></td>
        </tr>
    </tfoot>
</table>
<input id="total-payable" type="hidden" value="<?=number_format($totals,2);?>" />