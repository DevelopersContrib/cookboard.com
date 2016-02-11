<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/search-page.css",['depends' => 'app\assets\AppAsset']);
//$this->registerCssFile(Yii::$app->homeUrl."css/cook-settings.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/select2.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('.modal-dialog{color: #333;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
.ui-autocomplete-loading {
    background: white url("'.Yii::$app->homeUrl.'img/ui-anim_basic_16x16.gif") right center no-repeat;
}
.ui-autocomplete{
    z-index: 9999999;
}

input[type="checkbox"], input[type="radio"] {
    opacity: 1 !important;
}
.arrow{
	display:none;
}
');

$this->title = "Search";
$this->params['breadcrumbs'] =[
    $this->title,
];
?>
<script type="text/javascript">
    var gSearch;
</script>
<div id="wrapper-container" class="row wrapper-container">
    <div id="containerSetHeight">
        <div class="col-lg-12" style="display:none">	
            <h1 class="font-raleways font-300">
                Search for Food
            </h1>
            <br>
        </div>
		<div class="col-lg-12">
			<div class="top-search">
				<div class="input-group">
				  <input id="searchtext" type="text" class="form-control" placeholder="Search Food by Name">
				  <span class="input-group-btn">
					<button id="btn-search" class="btn btn-warning" type="button"><i class="fa fa-search"></i>&nbsp;Search</button>
				  </span>
				</div>
			</div>
		</div>
        <div class="col-lg-12">
            <div class="wrap-search-pageContainer">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">							
                            <div class="col-lg-12 searchbox">
                                <h3>Search By</h3>
                                <?php $form = ActiveForm::begin(['id'=>'search-form','method' => 'post']);?>
                                <div class="form-group">
                                    <div class="input-group csgroup">
                                        <input id="cuisine" name="cuisine" type="hidden" />
                                        <input id="q" name="q" type="hidden" />
                                        <input id="course" name="course" type="hidden" />
                                        <input id="diet" name="diet" type="hidden" />
                                        <input id="city" name="city" type="hidden" />
                                        <input id="type" name="type" type="hidden" />
                                        <input id="page" name="page" type="hidden" value='0' />
                                    </div><!-- /input-group -->
                                </div>
                                <?php ActiveForm::end(); ?>
                                <div class="row by-board">
                                    <div class="col-lg-6 city-container">
                                        <div class="form-group">
                                            <label>
                                                City
                                            </label>
<!--                                            <div id="citySelect" class="select2-container select2-container-multi" style="width: 100%;"></div>-->
                                            <input class="form-control cscinput" id="citySelect" style="border-radius:0px"  />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 diet-container">
                                        <div class="form-group">
                                            <label>
                                                Diet
                                            </label>
<!--                                            <div id="dietSelect" class="select2-container select2-container-multi" style="width: 100%;"></div>-->
                                            <select class="populate select2-offscreen" style="width: 100%;" id="dietSelect" name="dietSelect" multiple="" tabindex="-1">
                                                <?php
                                                    foreach($diet as $item){
                                                ?>
                                                <option value="<?=$item->id?>"><?=$item->name;?></option>
                                                <?php
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 cuisine-container">
                                        <div class="form-group">
                                            <label>
                                                Cuisine
                                            </label>
                                            <select class="populate select2-offscreen" style="width:100%" id="cuisineSelect" name="cuisineSelect" multiple="" tabindex="-1">
                                                <?php
                                                    foreach($cuisine as $item){
                                                ?>
                                                <option value="<?=$item->id?>"><?=$item->name;?></option>
                                                <?php
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 course-container">
                                        <div class="form-group">
                                            <label>
                                                Course
                                            </label>
                                            <select class="populate select2-offscreen" style="width: 100%;" id="courseSelect" name="courseSelect" multiple="" tabindex="-1">
                                                <?php
                                                    foreach($course as $item){
                                                ?>
                                                <option value="<?=$item->id?>"><?=$item->name;?></option>
                                                <?php
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input class="search-type radio-entry" <?=($type=="entry" || empty($type))?'checked=""':'';?> type="radio" value="entry" id="inlineRadio2" name="inlineRadioOptions" > by entry
                                    </label>
                                    <label class="radio-inline">
                                        <input class="search-type radio-board" <?=$type=="board"?'checked=""':'';?> type="radio" value="board" id="inlineRadio1" name="inlineRadioOptions"> by board
                                    </label>
                                    <label class="radio-inline">
                                        <input class="search-type radio-user" <?=$type=="user"?'checked=""':'';?> type="radio" value="user" id="inlineRadio3" name="inlineRadioOptions" > by user
                                    </label>
                                    <button id="btn-search2" style="display:none;" class="btn btn-warning pull-right" type="button">
                                        <i class="fa fa-search"></i>&nbsp;Search
                                    </button>
                                </div>
								<div style="clear:both;"><br></div>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    
                                    <div id="map-outer" class="col-md-12">          
                                        <div style="width:102.5%;height:266px;" id="map-container" class="col-md-12"></div>
                                    </div><!-- /map-outer -->
                                </div>
                            </div>
                        </div>
                </div>
        </div>
        </div>
        <div class="query" style="margin-top:-35px;">
        <?php
            if(count($models)>0){
                if($type==='board'){
                    foreach($models as $board){
                        echo $this->render('_board',['item'=>$board]);
                    }
                }elseif($type==='user'){
                    foreach($models as $user){
                        
                        echo $this->render('_user',['item'=>$user]);
                    }
                }else{
                    foreach($models as $entry){
                        echo $this->render('_entry',['item'=>$entry]);
                    }
                }
            }else{
				$c = empty($loc)?'':" in $loc";
				$m = empty($q)?'':" for $q";
				$msg = 'Oops no cookboard entries found'.$m.$c;
                echo '<div style="padding:15px; text-align:center;"><h2 style="background:#fff; padding:16px; font-size:35px; color:#7F5217;"><i class="fa fa-exclamation-triangle"></i>&nbsp;'.$msg.'</h2></div>';
                ?>
                <a style="opacity:0;width: 1px;"  tabindex="0" class="mWishlist btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Search">Dismissible popover</a>
<!--                <a id="testing" href="javascript:;">test</a>-->
                <?php
            }
        ?>
        <div style="clear:both;"></div>
        <div class="col-xs-12 text-center">
            <?php 
                echo app\components\LinkPagerCustom::widget([
                    'pagination' => $pages,
                ]);
            ?>            
        </div>
		<div style="clear:both;"></div>
    </div>
        
        <div class="col-lg-12">
            <br><br><br>
        </div>
        <?php if(!Yii::$app->user->isGuest){?>
        <?=$this->render('_pin_form',['cookboardlist'=>$cookboardlist, 'cookboard'=>$cookboard]);
        }
        ?>
        
        <?php if(!Yii::$app->user->isGuest){
        //echo $this->render('_wishlist_modal');
        }
?>
    </div>
</div>




<?php 
//$this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/select2.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/search/index.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJs($this->render('index_js.php',[
    'total_result'=>count($models),
	'ispost'=>$ispost,
    'q' => $q,
    'loc'=>$loc,
    'type'=>$type,
    'courseid' => $courseid,
    'cuisineid' => $cuisineid,
    'dietid' => $dietid,]));
?>


