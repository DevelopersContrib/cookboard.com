<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Checkout';

$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    $this->title,
];

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}

?>
<style>
    .subtotal{
        background-color:#eee;
    }
	#checkout-container {
	background-color:#fff;
	margin-right:0px;
	margin-left:0px;
	}
</style>

<div class="row" id="checkout-container">
    <div class="col-sm-12">
        <table class="table table-hover table-cook-cart">
            <thead>
                <tr>
                    <th>Board Entry</th>
                    <th>Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totals = 0;
                    foreach($perUser as $arr){
                        $totalPerUser = 0;
                        //foreach($items as $item){
                        foreach($arr as $item){
                            $user_id = $item->user_id;
                ?>
                <tr class="tr<?=$user_id;?> " data-id="<?=$user_id;?>">
                    <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <?php
                                $img = 'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/colored-icon.png';
                                if(!empty($item->boardEntryPhoto)){
                                    $photos = $item->boardEntryPhoto;
                                    
                                    if(count($photos)>0){
                                        $photo = $photos[0];
                                        $img = $photo->external?$photo->photo:Yii::$app->homeUrl.$photo->photo;
                                    }
                                }
                            ?>
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?=$img?>" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#"><?=$item->name?></a></h4>
                                <h5 class="media-heading"> by <a target="_blank" href="<?=Yii::$app->homeUrl.$item->user->slug;?>"><?=$item->user->username;?></a></h5>
                                <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                            </div>
                        </div>
                    </td>
                    <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input autocomplete="off" type="text" class="form-control qty" data-entry="<?=$item->id?>" id="<?=$item->id;?>" value="<?=$cart[$item->id]['qty']?>">
                        <input type="hidden" class="price" id="<?=$item->id;?>" value="<?=$item->price;?>">
                    </td>
                    <td class="col-sm-1 col-md-1 text-center"><strong><?=$item->price;?></strong></td>
                    <?php
                        $row_total = intval($cart[$item->id]['qty']) * floatval($item->price);
                    ?>
                    <td class="col-sm-1 col-md-1 text-center"><strong id="<?=$item->id?>" class="row-total row-total-<?=$user_id?>"><?=number_format($row_total,2)?></strong></td>
                    <td class="col-sm-1 col-md-1">
                    <button type="button" class="btn btn-sm btn-danger remove" data-name="<?=$item->name?>" id="<?=$item->id;?>" data-i="<?=$item->id;?>">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                    </td>
                </tr>
                <?php
                        $totals = $totals + $row_total;
                        $totalPerUser = $totalPerUser + $row_total;                        
                    }
                ?>
                <tr>
                    <td class="col-sm-8 col-md-6 subtotal"></td>
                    <td class="col-sm-1 col-md-1 subtotal"></td>
                    <td class="col-sm-1 col-md-1 text-center subtotal">Total:</td>
                    <td class="col-sm-1 col-md-1 text-center subtotal"><strong data-id="<?=$user_id;?>" class="total-per-user total-per-user-<?=$user_id?>"><?=number_format($totalPerUser,2);?></strong></td>
                    <td class="col-sm-1 col-md-1 subtotal">
                        <button id="<?=$user_id;?>" type="submit" class="btn btn-warning pull-right paynow" style="display:none;">
                            Pay Now <span class="glyphicon glyphicon-play"></span>
                        </button>
                        <button id="<?=$user_id;?>" type="submit" class="btn btn-warning pull-right podnow" style="display:none;">
                            POD <span class="glyphicon glyphicon-play"></span>
                        </button>
                        <button data-id="<?=$user_id;?>" type="submit" class="btn btn-warning pull-right ordernow" >
                            Order Now <span class="glyphicon glyphicon-play"></span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h3>Totals</h3></td>
                    <td class="text-right"><h3><strong class="totals"><?=number_format($totals,2);?></strong></h3></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                    
                    </td>
                    <td>
                        <?php $form = ActiveForm::begin(['id'=>'continue','method' => 'post','action' => ['checkout/cart']]);?>
                        <input type="hidden" name="redirect" value="<?=$referrer?>" />
                        <button type="submit" class="btn btn-default" id="btn-continue">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button>
                    <?php ActiveForm::end(); ?>
                    
                    <?php $form = ActiveForm::begin(['id'=>'paynow','method' => 'post','action' => ['checkout/submit']]);?>
                    <?php ActiveForm::end(); ?>
                    
                    <?php $form = ActiveForm::begin(['id'=>'pod','method' => 'post','action' => ['checkout/pod']]);?>
                    <?php ActiveForm::end(); ?>
                    
                        <?php /*$form = ActiveForm::begin(['id'=>'checkout','method' => 'post','action' => ['checkout/info']]);?>
                        <button type="submit" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button>
                    <?php ActiveForm::end(); */?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?=$this->render('_index_payment_modal');?>
</div>

<script type="text/javascript">
    var gCheckout;
</script>

<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/checkout/index.js',['depends' => 'app\assets\AppAsset'] );
$this->registerJs($this->render('index_js.php')); 
?>
