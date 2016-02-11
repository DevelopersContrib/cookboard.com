<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile(Yii::$app->homeUrl."css/jRating.jquery.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/lightbox.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name.' Favorite';

if(!Yii::$app->user->isGuest){
$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    ['label' => $model->cookboard->name, 'url' => ['cookboard/'.$model->cookboard->slug]],
    $this->title,
];
}else{
  $this->params['breadcrumbs'] =[
    ['label' => $model->cookboard->name, 'url' => ['cookboard/'.$model->cookboard->slug]],
    $this->title,
];  
}

?>
<style>
#imagelightbox
{
    position: fixed;
    z-index: 9999;
 
    -ms-touch-action: none;
    touch-action: none;
}
.dpage {
width:100%;
}
</style>
<div class="dpage" id="containerSetHeight">
    
    <div class="show-grid">
        
        <div id="details-container" class="col-xs-12 wrap-descriptionEntryDetails">
        <div class="col-md-4">
            <?php
                $photo = $model->boardEntryPhoto[0];
                echo $this->render('_photo_single',['id'=>$model->id,'photo'=>$photo,'cookboard_slug'=>$model->cookboard->slug, 'slug'=>$model->slug]);
                //echo $this->render('_photo_single',['photo'=>$photo,'slug'=>$model->slug]);
            ?>
        </div>
        <div class="col-md-4">
            <div class="wrap-descriptionEntryDetails font-raleways font-300">
            <h3><?=$model->name?></h3>
            <p class=" wded-desc">
                <?=$model->description?>
            </p>
            <ul class="list-inline text-capitalize">
                <li>
                    <span class="label label-warning text-capitalize">
                        cuisine: <?=$model->cuisine->name?>
                    </span> 
                </li>
                <li>
                    <span class="label label-danger text-capitalize">
                        course: <?=$model->course->name?>
                    </span>
                </li>
                <?php
                    if(!empty($model->diet_id)){
                ?>
                <li>
                    <span class="label label-info text-capitalize">
                        diets: <?=$model->diet->name?>
                    </span>
                </li>
                <?php
                    }
                ?>
            </ul>
            <ul class="list-unstyled">
                <li>
                    Location : <span class="text-warning"><?=$model->city?></span>
                </li>
                <?php if($model->post_type===app\models\BoardEntry::POST_TYPE_FOR_SALE){?>
                <li>
                    Delivery Type : <span class="text-warning"><?=$model->deliveryType->name?></span>
                </li>
                <li>
                    <h3>Price : <?=$model->priceType->name?> <?=$model->price?></h3>
                </li>
                <?php }?>
            </ul>
            
            <?php
                $attr = '';
                
            ?>
            <div class="text-center">
                <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                    <button <?=$attr?> type="button" class="btn btn-default">Favorite</button>
                    <?php
                        $display = '';
                        $likes = count($model->boardEntryLike);
                        if($likes>0){
                    ?>
                    <button id="likes" style="<?=$display;?>" type="button" class="btn btn-default"><?=$likes?></button>
                    <?php }?>
                </div>
            </div>
            
            <div id="rating-container" class="text-center">
                <div id="rating-text" style="help-block rate-block-text">
                    <?='Rating';?>
                </div>
                <div style="help-block rate-block-text">
                    <div class="star" data-average="<?=!empty($model->rating_count)?round((!empty($model->rating)?$model->rating:0) / $model->rating_count):0;?>" data-id="<?=$model->id?>"></div>
                </div>
            </div>
            
            </div>
        </div>
        <div class="col-md-4">
            
            <div class="wrap-userSolocontainer">
                <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                    <div class="wrap-imagePublicUser">
                        <?php
                            $img = !empty($model->user->photo)?Yii::$app->homeUrl.'pix/'.$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                        ?>
                        <img class="img-responsive img-circle " src="<?=$img?>">
                    </div>
                </a>
                <h3 class="text-center text-capitalize">
                    <a class="solo-user-link" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                        <i class="fa fa-cutlery"></i>
                        <?=$model->user->username?>
                    </a>
                </h3>

            </div>
        </div>
        </div>
    </div>
    
    
    


<?php
    foreach($items as $item){
        echo $this->render('_likes_user',['item'=>$item->user]);
    }
?>
</div>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/jRating.jquery.min.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('likes_js.php'));
