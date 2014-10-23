<?php
use yii\helpers\Html;

app\assets\ValidationAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/public-board.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;
if(!Yii::$app->user->isGuest){
    $this->params['breadcrumbs'] =[
        ['label' => 'Cook Board','url' => ['cookboard/index'],],
        $this->title,
    ];
}else{
    $this->params['breadcrumbs'] =[
        $this->title,
    ];
}

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}
?>
<div id="wrapper-container"  class="row wrapper-container">
    <div class="col-lg-12">
        <div class="wrap-publicBoard-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wrap-publicBoard-imgUser">
                        <?php
                            $img = !empty($model->user->photo)?Yii::$app->homeUrl.'pix/'.$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                        ?>
                        <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                        <img class="img-responsive" src="<?=$img?>">
                        </a>
                    </div>
                    <div class="text-center text-capitalize font-300 font-raleways">
                        <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>"><h1><?=$model->user->username?></h1></a>
                        <?php /*?>
                        <p>
                            <i class="fa fa-map-marker"></i> 
                            davao city
                        </p><?php */?>
                        <h1 class="font-raleways font-300"><?=ucwords($model->name)?></h1>
                        <p class="font-raleways font-300"><?=$model->description?></p>
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
</div>

<div id="containerSetHeight" class="cookboard">
    <div class="row">
        <div class="cookboard">
            <?php
            if(!Yii::$app->user->isGuest){
            ?>
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
            }
            ?>
            <?php
                foreach($model->boardEntry as $entry){
                    echo $this->render('_entry',['item'=>$entry]);
                }
            
                foreach($pins as $pin){
                    echo $this->render('_pinned_entry',['pin'=>$pin]);
                }
            ?>
        </div>
    </div>            
</div>

<script type="text/javascript">
    var gCookboardDetails;
</script>
<?php 
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
if(!Yii::$app->user->isGuest){
    $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/details.js',['depends' => 'yii\web\AssetBundle'] );
}
$this->registerJs($this->render('details_js.php'));
?>
