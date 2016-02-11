<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile(Yii::$app->homeUrl."css/jRating.jquery.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/solo-entry.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/lightbox.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/review.css",['depends' => 'app\assets\AppAsset']);

$this->title = $model->name;

$parent_cookboard = $parent_cookboard?$parent_cookboard:$model->cookboard;
$isPinned = $parent_cookboard->id !== $model->cookboard->id;

if(!Yii::$app->user->isGuest){
$this->params['breadcrumbs'] =[
    ['label' => 'Cook Board','url' => ['cookboard/index'],],
    ['label' => $parent_cookboard->name, 'url' => ['cookboard/'.$parent_cookboard->slug]],
    $this->title,
];
}else{
  $this->params['breadcrumbs'] =[
    ['label' => $parent_cookboard->name, 'url' => ['cookboard/'.$parent_cookboard->slug]],
    $this->title,
];  
}

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}

?>
<style>
	#imagelightbox{
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
	.pub-img{
		display: inline-block;
		margin-left: 5px;
		margin-right: 10px;
		margin-top: 5px;
	}
	.wrap-publicBoard-imgUser.cookboard-entryboard {
		border: 5px solid #fff;
		border-radius: 50%;
		box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);
		height: 90px;
		overflow: hidden;
		width: 90px;
	}
	.pub-name {
		display: inline-block;
		vertical-align: top;
		color: #222;
	}
	.pub-name:hover{
		color: #777;
	}
	.wrap-container-user-entry{
		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 15px;
	}
	.star{
		margin:0;
	}
</style>
<?php 
    $prev = $model->prevEntry($parent_cookboard->id);
    $next = $model->nextEntry($parent_cookboard->id);
    
    $prev_url = '';
    $next_url = '';
    
    if($prev)
        $prev_url = Yii::$app->urlManager->createUrl(['boardentry/details', 'slug' => 
            $prev['slug'],'cookboard'=>$parent_cookboard->slug]);
    
    if($next)
    $next_url = Yii::$app->urlManager->createUrl(['boardentry/details', 'slug' => 
        $next['slug'],'cookboard'=>$parent_cookboard->slug]);
		
	
	$metadata = [];
    if(!empty($model->user->userMeta)){
        foreach($model->user->userMeta as $meta){
            $key = $meta->meta_key;
            $value = $meta->meta_value;
            $metadata = array_merge(["$key"=>$value],$metadata);
        }
    }
?>
<div class="entry-box">
    
<div class="col-md-1 arrow-left">
    <?php if(!empty($prev_url)){?>
	<a href="<?=$prev_url?>"><i class="fa fa-chevron-left farrow"></i></a>
    <?php }?>
</div>
    
<div class="col-md-10">
	<div class="user-top">
		<div class="row">	
			<div id="details-container" class="col-xs-12 wrap-descriptionEntryDetails">
			<div class="col-md-6">
				
				<?php if($isPinned){?>
				<span class="text-capitalize pinned">
                    <img src="http://cookboard.com/images/pin1.png">
                    Pinned from <a href="<?=\Yii::$app->urlManager->createUrl(['cookboard/details', 'slug' => $model->cookboard->slug]);?>"><?=$model->cookboard->name?></a>
                </span>
				<?php }?>
				
				<?php

					$photo = $model->boardEntryPhoto[0];
					echo $this->render('_photo_single',['id'=>$model->id, 'photo'=>$photo,'cookboard_slug'=>$parent_cookboard->slug, 
						'slug'=>$model->slug,'post_type'=>$model->post_type,'model'=>$model,'userCan'=>$userCan]);
				?>
				<!-- Go to www.addthis.com/dashboard to customize your tools -->
<br /><div class="addthis_sharing_toolbox"></div>
			</div>
			<div class="col-md-6">
				<div class="wrap-descriptionEntryDetails font-raleways font-300">
				<!---->
				<div class="wrap-container-user-entry">
					<div class="media">
						<div class="pull-left">
							<a class="pub-img" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
								<div class="wrap-publicBoard-imgUser cookboard-entryboard">
									<?php
										$img = !empty($model->user->photo)?Yii::$app->homeUrl.'pix/'.$model->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
									?>
									<img class="img-responsive" src="<?=$img?>">
								</div>
							</a>
						</div>
						<div class="media-body">
							<a class="pub-name" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $model->user->slug]);?>">
								<h1><?=$model->user->username?></h1>
							</a>

							<p>No. of boards: <?=$cookboardcount?></p>
							<p>No. of entries: <?=$boardentrycount?></p>
							<?php
								$totalRating = round($likescount/$boardentrycount);
								if($totalRating>0){
							?>
							<p>
								Rating: <div class="totalrating" data-average="<?=$totalRating?>"></div>
							</p>
							<?php
								}
							?>
							<p>
								Located @ <a data-profile="<?=$model->user->id?>" class="popup_map" href="javascript:;"><?=!empty($metadata['location'])?$metadata['location']:'';?></a>
							</p>
						</div>
					</div>
				</div>
				<!---->
				
				<h3 id="entry-<?=$model->id?>"><?=$model->name?></h3>
				<p class=" wded-desc">
					<?=$model->description?>
				</p>
				<ul class="list-inline text-capitalize">
                                        <?php if(!empty($model->cuisine)){?>
					<li>
						<span class="label label-warning text-capitalize">
							cuisine: <?=$model->cuisine->name?>
						</span> 
					</li>
                                        <?php }?>
                                        <?php if(!empty($model->course)){?>
					<li>
						<span class="label label-danger text-capitalize">
							course: <?=$model->course->name?>
						</span>
					</li>
                                        <?php }?>
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
                                        <?php if(!empty($model->city)){?>
					<li>
						Location : <span class="text-warning"><?=$model->city?></span>
					</li>
                                        <?php }?>
					<?php if($model->post_type===app\models\BoardEntry::POST_TYPE_FOR_SALE){?>
                                        <?php if(!empty($model->deliveryType)){?>
					<li>
						Delivery Type : <span class="text-warning"><?=$model->deliveryType->name?></span>
					</li>
                                        <?php }?>
					<?php if($model->days_to_prepare>0){?>
					<li>
						Days To Prepare : <span class="text-warning"><?=$model->days_to_prepare?></span>
					</li>
					<?php }?>
                                        <?php if(!empty($model->priceType)){?>
					<li>
						<h3>Price : <?=$model->priceType->name?> <?=$model->price?></h3>
					</li>
                                        <?php }?>
                                            <?php if(!empty($sales)){?>
                                        <li>
						<h3>Total Sales : <?=$sales?></h3>
					</li>
                                        <?php }}?>
				</ul>
				<?php
					//if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
					if($userCan['edit']){
				?>
				<a class="btn btn-warning btn-sm remove-pic" href="<?=Yii::$app->urlManager->createUrl(['boardentry/update', 'slug' => $model->slug]);?>">
						<i class="fa fa-edit"></i>
						Edit
				</a>
				<?php
					}
				?>
				
				<?php
					$attr = '';
					if($userCan['like']){
						$attr = "data-id='".$model->id."' id='like'";
					}
				?>
				<div>
					<div class="btn-group btn-group-md" role="group" aria-label="Large button group">
						<button <?=$attr?> type="button" data-loading-text="Favorite..." class="btn btn-default">Favorite</button>
						<?php
							$display = '';
							$likes = count($model->boardEntryLike);
							//$display = ($likes>0)?'display:block':'display:none';
							if($likes>0){
						?>
						<a id="likes" href="<?=Yii::$app->urlManager->createUrl(['boardentry/likes', 'slug' => $model->slug]);?>" style="<?=$display;?>" class="btn btn-default"><?=$likes?></a>
						<?php }?>
					</div>
					
					<?php
						if(!Yii::$app->user->isGuest && $model->user_id !== Yii::$app->user->getId()){
							if(!$model->isPinned()){
					?>
					
					<button id="<?=$model->id?>" class="btn btn-warning pin-btn" title="Pin this board.">
						Pin <i class="fa fa-cutlery"></i>
					</button>
					<?php }}?>
					
				</div>
				
				<div id="rating-container">
					<div id="rating-text" style="help-block rate-block-text">
						<?=$userCan['rate']?'Rate this entry.':'Rating';?>
					</div>
					<?php
					//var_dump($model->rating_count);
					//var_dump($model->rating);
					?>
					<div style="help-block rate-block-text text-left">
						<div class="star" data-average="<?=!empty($model->rating_count)?round((!empty($model->rating)?$model->rating:0) / $model->rating_count):0;?>" data-id="<?=$model->id?>"></div>
					</div>
				</div>
				
				
				<ul class="list-inline text-capitalize establishments">
					<?php
						foreach($model->boardEntryEstablishments as $item){
					?>
					<li>
						<span class="resto">
							<img src="http://cookboard.com/images/building1.png"> <?=$item->establishments->name?>
						</span> 
					</li>
					<?php
						}
					?>
				</ul>
				
				</div>
			</div>
			<?php /*?>
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
			<?php */?>
		
			<?php if(!Yii::$app->user->isGuest){?>
			<?=$this->render('_pin_form',['cookboardlist'=>$cookboardlist, 'cookboard'=>$cookboard]);
			}
			?>
			</div>
		</div>
	</div>
   
    <div class="user-bottom">		
        <div class="col-lg-12">
            <div id="wrapper-container"  class="row wrapper-container">
                <div id="containerSetHeight">
                    <?php
                        foreach($model->boardEntryPhoto as $photo){
                                echo $this->render('_photo',['photo'=>$photo]);
                        }
                       
                    ?>
                </div>
            </div>
        </div>	
    </div>
		<div id="wrap-thumbnails-box" class="col-lg-12 wrap-thumbnails-box" style="display:none">
			<h2>Related Entries</h2>
			<div id="wrap-thumbnails" class="wrap-thumbnails">
			<?php /*?>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<a href="#"><img src="https://s-media-cache-ak0.pinimg.com/236x/aa/2b/af/aa2baff473de6f341bd03cc289ebd5ee.jpg"></a>
			<?php */?>
			</div>
		</div>
</div>
    
    <div class="col-md-1 arrow-right">
        <?php if(!empty($next_url)){?>
        <a href="<?=$next_url?>"><i class="fa fa-chevron-right farrow"></i></a>
        <?php }?>
    </div>
    <div style="clear:both"></div>
	
	<?php		
		echo $this->render('_review',['model'=>$model,'currentuser'=>$currentuser]);
	?>
</div>


<?php 

$this->registerMetaTag([
    'name' => 'title',
    'content' => $model->name
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->description
]);

$firstimg = $photo->external===1?$photo->photo:Yii::$app->urlManager->createAbsoluteUrl('site/index').$photo->photo;

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => $firstimg
]);

$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imagelightbox.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/lightbox.js',['depends' => 'yii\web\AssetBundle'] );

//$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/jRating.jquery.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/jRating.jquery.js',['depends' => 'yii\web\AssetBundle'] );

$this->registerJsFile(Yii::$app->homeUrl.'js/boardentry/details.js',['depends' => 'yii\web\AssetBundle'] );

if($userCan['rate']){
    $this->registerJsFile(Yii::$app->homeUrl.'js/boardentry/details_rating.js',['depends' => 'yii\web\AssetBundle'] );
}

$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('details_js.php',['gocart'=>$gocart,'slug'=>$model->slug, 
	'canRate'=>$userCan['rate'],'canLike'=>$userCan['like']]));

/*if(!empty($model->city) || !empty($model->latlng)){
    $this->registerJsFile(Yii::$app->homeUrl.'js/site/map.js',['depends' => 'yii\web\AssetBundle'] );
    $this->registerJs($this->render('details_map_js.php',['model'=>$model])); 
    $this->registerCss('
        .wrap-googlemapsContainer {
            height: 150px;
        }
    ');
}*/
?>