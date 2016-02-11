<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile(Yii::$app->homeUrl."css/jRating.jquery.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/lightbox.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;

if(!Yii::$app->user->isGuest){
$this->params['breadcrumbs'] =[
    $this->title,
];
}else{
  $this->params['breadcrumbs'] =[
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
.user-top {
margin-right:15px;
margin-left:15px;
}
.wrap-imagePublicUser {
float:left;
}
.wrap-googlemapsContainer {
    height: 240px;
    margin-bottom: 15px;
}
.farrow {
font-size:52px;
color:#888;
margin-top:300px;
}
.farrow:hover {
color:#333;
}
.arrow-right {
text-align:right;
}
.entry-box .col-md-1, .entry-box .col-md-10 {
padding-right:0px;
padding-left:0px;
}
.entry-box .col-md-1 {
width: 3.333%;
}
.entry-box .col-md-10 {
width: 93.333%;
}
@media all and (max-width: 600px) {
    .entry-box .arrow-left, .entry-box .arrow-right{
        display:none;
    }
}
@media all and (max-width: 600px) {
    .entry-box .col-md-10{
        width:100%;
    }
}
.entry-box {
padding-top:30px;
background:#F0EEE5;
box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.2);
}
</style>

<div class="entry-box">
    
<div class="col-md-1 arrow-left">
    
</div>
<div class="col-md-10">
	<div class="user-top">
		<div class="row">	
			<div id="details-container" class="col-xs-12 wrap-descriptionEntryDetails">
			<div class="col-md-4">
				<?php
                                    $photo = $model->photo;
				?>
                            <div class="paddItem item photo-entry">
                                <div class="wrap-item">
                                    <div class="wrap-item-img">
                                        <?php
                                            $img = Yii::$app->homeUrl.$photo;
                                        ?>
                                        <a class="photo" href="javascript:;" >
                                            <img id="pic-<?=$model->id?>" class="img-responsive" alt="<?=$model->name?>" src="<?=$img?>" />
                                        </a>
                                    </div>

                                </div>
                            </div>
				<!-- Go to www.addthis.com/dashboard to customize your tools -->
<br /><div class="addthis_sharing_toolbox"></div>
			</div>
			<div class="col-md-4">
				<div class="wrap-descriptionEntryDetails font-raleways font-300">
				<h3 id="entry-<?=$model->id?>"><?=$model->name?></h3>
				<p class=" wded-desc">
					<?=$model->review?>
				</p>
				
				<div class="text-center">
					
					
				</div>
				
				<div id="rating-container" class="text-center">
					<div id="rating-text" style="help-block rate-block-text">
						<?='Rating';?>
					</div>
					<div style="help-block rate-block-text">
						<div class="star" data-average="<?=$model->rating;?>" data-id="<?=$model->id?>"></div>
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
					<div class="clearfix"></div>
				</div>
						<h3><?=$model->name?> location:</h3>
						<div id="map-container" class="wrap-googlemapsContainer"></div>
			</div>
		
			
			</div>
		</div>
	</div>
   
    
</div>
    
   <div class="col-md-1 arrow-right">
       
    </div>
    <div style="clear:both"></div>
</div>


<?php
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imagelightbox.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/lightbox.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/jRating.jquery.min.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJsFile(Yii::$app->homeUrl.'js/establishment/index.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('index_js.php',['slug'=>$model->slug]));

if(!empty($model->location)){
    $this->registerJsFile(Yii::$app->homeUrl.'js/site/map.js',['depends' => 'yii\web\AssetBundle'] );
    $this->registerJs($this->render('index_map_js.php',['model'=>$model])); 
    $this->registerCss('
        .wrap-googlemapsContainer {
            height: 150px;
        }
    ');
}

?>