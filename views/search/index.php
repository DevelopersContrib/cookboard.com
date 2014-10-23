<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/search-page.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/cook-settings.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('.modal-dialog{color: #333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}');

$this->title = "Search";
$this->params['breadcrumbs'] =[
    $this->title,
];
?>
<div id="wrapper-container" class="row wrapper-container">
    <div id="containerSetHeight">
        <div class="col-lg-12">	
            <h1 class="font-raleways font-300">
                Search for Food
            </h1>
            <br>
        </div>
        <div class="col-lg-12">
            <div class="wrap-search-pageContainer">
                <div class="row">
                    <?=$this->render('_cuisine',['cuisine'=>$cuisine]);?>
                    <?=$this->render('_course',['course'=>$course]);?>
                    <div class="col-lg-6">
                        <h3>Or you might want to search directly</h3>
                        <div class="form-group">
                            <?php $form = ActiveForm::begin(['id'=>'search-form','method' => 'post']);?>
                            <div class="input-group">
                                <input id="searchtext" name="q" type="text" class="form-control" placeholder="Find by name">
                                <input id="cuisine" name="cuisine" type="hidden" >
                                <input id="course" name="course" type="hidden" >
                                <span class="input-group-btn">
                                    <button id="btn-search" data-loading-text="Saving..." class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div><!-- /input-group -->
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> by board
                            </label>
                            <label class="radio-inline">
                                <input type="radio" checked name="inlineRadioOptions" id="inlineRadio2" value="option2"> by entry
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if(count($models)>0){
                foreach($models as $entry){
                    echo $this->render('_entry',['item'=>$entry]);
                }            
            }else{
                echo '<h1>No Records found.</h1>';
            }
        ?>
        
        <div class="col-lg-12 text-center">
            <?php 
                echo app\components\LinkPagerCustom::widget([
                    'pagination' => $pages,
                ]);
            ?>            
        </div>
        <div class="col-lg-12">
            <br><br><br>
        </div>
        <?=$this->render('_pin_form',['cookboardlist'=>$cookboardlist, 'cookboard'=>$cookboard]);?>
    </div>
</div>

<script type="text/javascript">
    var gSearch;
</script>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/search/index.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('index_js.php')); ?>