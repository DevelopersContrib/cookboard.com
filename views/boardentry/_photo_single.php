<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="paddItem item photo-entry">
    <div class="wrap-item">
	<?php
            if($post_type === app\models\BoardEntry::POST_TYPE_FOR_SALE){
        ?>
        <div class="ribbon-wrapper-orange"><div class="ribbon-orange">For Sale!</div></div>
        <?php
            }
        ?>
        <div class="wrap-item-img">
            <?php
                $img = $photo->external===1?$photo->photo:Yii::$app->homeUrl.$photo->photo;
            ?>
            <?php /*?><a class="photo" href="<?=Yii::$app->urlManager->createUrl(['boardentry/details','cookboard'=>$cookboard_slug, 'slug' => $slug])?>" ><?php */?>
			<?php ?><a class="photo" href="<?=$img?>" ><?php ?>
                <img id="pic-<?=$id?>" class="img-responsive" alt="<?=$photo->title?>" src="<?=$img?>" />
            </a>
        </div>        
    </div>	
</div>
<?php if($userCan['buy'] && $model->post_type===app\models\BoardEntry::POST_TYPE_FOR_SALE){ ?>
<div style="margin-top:10px">
    <?php $form = ActiveForm::begin(['id'=>'checkout','method' => 'post','action' => ['checkout/index']]);?>
        <?= Html::activeHiddenInput($model, 'id')?>
        <input type="hidden" name="referrer" value="<?=Yii::$app->request->referrer?>" />
        <button class="btn btn-default btn-lg" type="submit">
            <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
        </button>
    <?php ActiveForm::end(); ?>
</div>
<?php }else if($userCan['buy']==false && $model->post_type===app\models\BoardEntry::POST_TYPE_FOR_SALE){?>
<div style="margin-top:10px">
    <a class="btn btn-default btn-lg" href="/login?redirect=<?=rawurlencode(Yii::$app->urlManager->createUrl(['boardentry/details',
		'cookboard'=>$parent_cookboard->slug, 'slug' => $model->slug]))?>">
        <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart
    </a>
</div>
<?php }?>