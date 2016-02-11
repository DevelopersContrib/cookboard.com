<?php
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
    <div class="col-lg-8">
        <div id="containerSetHeight" class="cookboard">
            <div class="row">
                <div class="cookboard">
                    <?php
                    //if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
                    if($model->canEdit()){
                    ?>
                    <div id="defaultboard" class="col-xs-12 col-sm-6 col-lg-4 paddItem item">
<!--                        <a href="<?=Yii::$app->urlManager->createUrl(['boardentry/create', 'id' => $model->id]);?>" class="wrap-modal-add add-entry" id='add-entry'>-->
                        <a href="javascript:;" class="wrap-modal-add add-entry" id='add-entry' data-id="<?=$model->id?>">
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
    </div>
    <div class="col-lg-4">
        <div class="wrap-publicBoard-container">
            <div class="row">
                <div class="col-lg-12">
                    <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
                        <div class="wrap-publicBoard-imgUser cookboard-entryboard">
                            <?php
                                $img = !empty($model->user->photo)?Yii::$app->homeUrl.'pix/'.$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                            ?>
                            <img class="img-responsive" src="<?=$img?>">
                        </div>
                    </a>
                    <div class="text-center text-capitalize font-300 font-raleways">
                        <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>"><h1><?=$model->user->username?></h1></a>
                        <h1 id="cookboard-details-name" class="font-raleways font-300"><?=ucwords($model->name)?></h1>
                        <p id="cookboard-details-description" class="font-raleways font-300"><?=$model->description?></p>
                    </div>
                    
                    <?php
                        if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
                    ?>
                        <div class="text-center">
                            <a id="<?=$model->id?>" class="btn btn-warning btn-sm remove-pic edit-cookboard" href="javascript:;">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>
                            <a id="<?=$model->id?>" class="btn btn-danger btn-sm remove-pic delete-cookboard" href="javascript:;">
                                Delete
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    <?php
                        }
                    ?>
                    
                </div>
            </div>
        </div>
        <div class="wrap-publicBoard-container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="map-container" class="wrap-googlemapsContainer">
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<script type="text/javascript">
    var gCookboardDetails;
    var gFormCookboard;
    var gDetailsAddEntryModal;
</script>

<?php
    //if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
    if($model->canEdit()){
?>
<?= $this->render('_details_form_cookboard',['cookboard'=>$model]); ?>
<?= $this->render('_details_add_entry_modal',['cookboard'=>$model]); ?>
<?php
    }

$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
//if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
if($model->canEdit()){
    $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/details.js',['depends' => 'yii\web\AssetBundle'] );
}
$this->registerJs($this->render('details_js.php',['model'=>$model]));
?>

<?php 
    $metadata = [];
    if(!empty($model->user->userMeta)){
        foreach($model->user->userMeta as $meta){
            $key = $meta->meta_key;
            $value = $meta->meta_value;
            $metadata = array_merge(["$key"=>$value],$metadata);
        }
    }
    if(!empty($metadata['location']) || !empty($metadata['latlng'])){
        $this->registerJsFile(Yii::$app->homeUrl.'js/site/map.js',['depends' => 'yii\web\AssetBundle'] );
        $this->registerJs($this->render('details_map_js.php',['metadata'=>$metadata])); 
    }
?>