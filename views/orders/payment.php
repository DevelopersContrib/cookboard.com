<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    
    $u = $payment->paymentFrom;
?>

<form>
    <div class="row show-grid">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label">Order #</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><?=$payment->order->id?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Date</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=date("m/d/Y", strtotime($payment->datetime_created));?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">From</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]);?>"><?=$u->username;?></a></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Payer Email</label>
                <div class="col-sm-8">
                  <p class="form-control-static"><?=$payment->payer_email?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label">Amount</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=  number_format($payment->amount,2)?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=$payment->status?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Paid To</label>
                <div class="col-sm-8">
                    <p class="form-control-static"><?=$payment->receiver_email?></p>
                </div>
            </div>
        </div>
    </div>
</form>