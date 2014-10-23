<?php
use yii\helpers\Html;

app\assets\ValidationAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
//$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/public-board.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;;

$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    $this->title,
];

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}
?>
<?php /*?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="font-raleways font-300"><?=ucwords($model->name)?></h1>
        <p class="font-raleways font-300"><?=$model->description?></p>
        <br>
    </div>
</div>
<?php */?>
<div id="wrapper-container"  class="row wrapper-container">

<div id="containerSetHeight" class="cookboard">
    <div class="col-lg-12">
        <div class="wrap-publicBoard-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrap-publicBoard-imgUser">
                        <?php
                            $img = !empty($model->user->photo)?$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                        ?>
                        <img class="img-responsive" src="<?=$img?>">
                    </div>
                    <div class="text-center text-capitalize font-300 font-raleways">
                        <h1><?=$model->user->username?></h1>
                        <p>
                            <i class="fa fa-map-marker"></i> 
                            davao city
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wrap-googlemapsContainer">
                        <img class="img-responsive" src="http://www.cabag.ch/uploads/pics/google_maps4_01.gif">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php /*?>
    <!--<div class="row">-->
        <div class="cookboard">
            <div id="defaultboard" class="col-xs-12 col-sm-6 col-lg-3 paddItem item">
                <!-- Button trigger modal -->
                <a href="<?=Yii::$app->urlManager->createUrl(['boardentry/create', 'id' => $model->id]);?>" class="wrap-modal-add" id='add-entry'>
                    <div class="wrap-container-modal-add text-center font-raleways font-300">
                        <i class="fa fa-plus fa-4x"></i>
                        <div class="wrap-block">
                            Add Entry
                        </div>
                    </div>
                </a>
            </div>
            <?php
                foreach($model->boardEntry as $entry){
                    echo $this->render('_entry',['item'=>$entry]);
                }
            ?>
        </div>
    <!--</div>-->
    <?php */?>
    <?php
        foreach($model->boardEntry as $entry){
            echo $this->render('_entry',['item'=>$entry]);
        }
    ?>
</div>
</div>
<script type="text/javascript">
    var gCookboardDetails;
</script>
<?php $this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/details.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('details_js.php')); ?>
