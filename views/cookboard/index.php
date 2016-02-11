<?php
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('.modal-dialog{color: #333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}');

$this->title = "Cook Board";
$this->params['breadcrumbs'] =[
    $this->title,
];

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}

?>


<div id="containerSetHeight" class="cookboard">
    <div id="defaultboard" class="col-xs-12 col-sm-6 col-lg-3 paddItem">
        <!-- Button trigger modal -->
<!--        <a href="<?=Yii::$app->homeUrl.'boardentry/'?>" class="wrap-modal-add" id='add-cookboard'>-->
        <a href="javascript:;" class="wrap-modal-add" id='add-cookboard'>
            <div class="wrap-container-modal-add text-center font-raleways font-300">
                <i class="fa fa-plus fa-4x"></i>
                <div class="wrap-block">
                    Add Cook Board
                </div>
            </div>
        </a>
    </div>
    <?php
        foreach($model as $item){
            echo $this->render('_board',['item'=>$item]);
        }
    ?>
</div>
<script type="text/javascript">
    var gCookboard;
    var gFormCookboard;
</script>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/cookboard/index.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?= $this->render('_form_cookboard',['cookboard'=>$cookboard]); ?>
<?php $this->registerJs($this->render('index_js.php')); ?>
