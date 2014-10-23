<?php

$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;

if(!Yii::$app->user->isGuest){
$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    ['label' => $model->cookboard->name, 'url' => ['cookboard/'.$model->cookboard->id]],
    $this->title,
];
}else{
  $this->params['breadcrumbs'] =[
    ['label' => $model->cookboard->name, 'url' => ['cookboard/'.$model->cookboard->id]],
    $this->title,
];  
}


?>
<div class="row">
    <div class="col-lg-12">
        <div class="wrap-descriptionEntryDetails font-raleways font-300">
                <div class="wrap-imagePublicUser">
                    <?php
                        $img = !empty($model->user->photo)?Yii::$app->homeUrl.'pix/'.$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                    ?>
                    <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                    <img class="img-responsive img-circle " src="<?=$img?>">
                    </a>
                </div>
            <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                <h3 class="text-center text-capitalize">
                    <?=$model->user->username?>
                </h3>
            </a>
                <h1 class="text-center"><?=$model->name?></h1>
                <p class="text-center wded-desc">
                    <?=$model->description?>
                </p>
                <ul class="list-unstyled text-center text-capitalize">
                    <li>
                        Location : <span class="text-warning"><?=$model->city?></span>
                    </li>
                    <li>
                        Delivery Type : <span class="text-warning"><?=$model->deliveryType->name?></span>
                    </li>
                    <li>
                        <h3>Price : <?=$model->priceType->name?> <?=$model->price?></h3>
                    </li>
                </ul>
                <ul class="list-inline text-center">
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
        </div>
    </div>
</div>

<div id="wrapper-container"  class="row wrapper-container">
    <div id="containerSetHeight">
    <?php
        foreach($model->boardEntryPhoto as $photo){
            echo $this->render('_photo',['photo'=>$photo]);
        }
    ?>
</div>
</div>
<?php $this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('details_js.php')); ?>