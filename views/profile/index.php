<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
.profile-right h3 {
	margin:0px;
	margin-bottom:10px;
	margin: 0px;
	padding: 10px 15px;
	background: #f5f5f5;
}
.profile-right .sdbtn {
	display: inline-block;	
	margin-top: 8px;
	margin-bottom: 15px;
	vertical-align: middle;
}
.profile-right .nmembers {
	margin-top:8px;
}
.profile-right .nmembers img {
	margin-bottom:4px;
}

.ttpage.active{
	display:block !important;
}
</style>
<?php 
$this->registerCssFile(Yii::$app->homeUrl."css/cook-profile.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/jquery.dataTables.css",['depends' => 'app\assets\AppAsset']);

$this->title = empty($title)?$profile->username:'Dashboard';
$this->params['breadcrumbs'] =[
    $this->title,
];

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}
?>
<!-- profile-container -->
<div class="profile-container">			
  <div class="col-md-12 col-md-8">
        <div class="profile-left">
                <div class="pro-fol">
                        <div class="btn-group">
                          <a href="<?=Yii::$app->urlManager->createUrl(['profile/likes', 'slug' => $profile->slug]);?>" class="btn btn-default">Favorite&nbsp;<b><?=$likes?></b></a>
                          <a id="btn-followers" href="<?=Yii::$app->urlManager->createUrl(['profile/followers', 'slug' => $profile->slug]);?>" class="btn btn-default">Followers&nbsp;<b><?=($followers);?></b></a>
                          <a class="btn btn-default" href="<?=Yii::$app->urlManager->createUrl(['profile/following', 'slug' => $profile->slug]);?>">Following&nbsp;<b><?=($following);?></b></a>
                        </div>
                    <?php if($canFollow){?>
                    <button id="btn-follow" data-id="<?=$profile->id?>" data-loading-text="following..." type="button" class="btn btn btn-warning">Follow</button>
                    <button id="follower" data-id="<?=$profile->id?>" data-loading-text="unfollowing..." type="button" class="btn btn btn-warning" style="display:none"><i class="fa fa-check"></i> Following</button>
					<?php }else if($follower){?>
					<button id="btn-follow" data-id="<?=$profile->id?>" data-loading-text="following..." style="display:none" type="button" class="btn btn btn-warning">Follow</button>
					<button id="follower" data-id="<?=$profile->id?>" data-loading-text="unfollowing..." type="button" class="btn btn btn-warning"><i class="fa fa-check"></i> Following</button>
					<?php }?>
                </div>
				<?php //if(!$isOwner){?>
				<div class="pull-left">
					<p class="help-block">
						<b>
							BoardFeeds
						</b>
					</p>
				</div>
				
                <div style="clear:both"></div>
				<div id="wrapper-container" class="row wrapper-container ttpage <?=empty($tab)?'active':'';?>" style="display:none;">
					<?php
						echo $this->render('_index_boards2',['cookboard'=>$cookboard2]);
					?>
				</div>
				<?php if($isOwner){?>
					<div class="ttpage <?=$tab=='boards'?'active':'';?>" id="boards" style="display:none;">
						<div id="w0" class="row wrapper-container">
                        <?php
                            foreach($cookboard as $item){
                                echo $this->render('_index_boards',['item'=>$item]);
                            }
                        ?>
						</div>
					</div>
					<div class="ttpage <?=$tab=='purchases'?'active':'';?>" id="purchases" style="display:none;">
					<?=$this->render('_index_purchases',['purchases'=>$purchases])?>
					</div>
					<div class="ttpage <?=$tab=='my_payments'?'active':'';?>" id="my-payments" style="display:none;">
					<?=$this->render('_index_my_payments',['my_payments'=>$my_payments])?>
					</div>
					<div class="ttpage <?=$tab=='orders'?'active':'';?>" id="orders" style="display:none;">
					<?=$this->render('_index_orders',['orders'=>$orders])?>
					</div>
					<div class="ttpage <?=$tab=='orders_payment'?'active':'';?>" id="orders-payment" style="display:none;">
					<?=$this->render('_index_orders_payment',['orders_payment'=>$orders_payment])?>
					</div>
					<div class="ttpage <?=$tab=='establishments'?'active':'';?>" id="establishments" style="display:none;">
					<?=$this->render('_index_establishments',['establishments'=>$establishments,
					'establishments_model'=>$establishments_model])?>
					</div>
				<?php }?>
				
				
				<?php 
				/*}else{
				?>
				
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li <?=empty($tab)||$tab=='boards'?'class="active"':'';?>><a href="#boards" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Boards</a></li>
                  <?php if($isOwner){?>
                  <li <?=$tab=='purchases'?'class="dropdown active"':'class="dropdown"';?>>
                      <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><span class="glyphicon glyphicon-list"></span> My Entry Purchases <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                        <li><a href="#purchases" tabindex="-1" role="tab" id="" data-toggle="tab" aria-controls="dropdown1">Entry Purchases</a></li>
                        <li><a href="#my-payments" tabindex="-1" role="tab" id="" data-toggle="tab" aria-controls="dropdown2">Entry Payments</a></li>
                      </ul>
                  </li>
                  <li <?=$tab=='orders'?'class="dropdown active"':'class="dropdown"';?>>
                      <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false"><span class="glyphicon glyphicon-list"></span> My Board Orders <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                        <li><a href="#orders" tabindex="-1" role="tab" id="" data-toggle="tab" aria-controls="dropdown1">Board  Orders</a></li>
                        <li><a href="#orders-payment" tabindex="-1" role="tab" id="" data-toggle="tab" aria-controls="dropdown2">Received Payments</a></li>
                      </ul>
                  </li>
                  <li <?=$tab=='establishment'?'class="active"':'';?>><a href="#establishments" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-list"></span>&nbsp;Establishment</a></li>
                      <?php }?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tc-pad">
                  <div class="tab-pane <?=empty($tab)||$tab=='boards'?'active':'';?>" id="boards">
                        <?php
                            foreach($cookboard as $item){
                                echo $this->render('_index_boards',['item'=>$item]);
                            }
                        ?>
                  </div>
                    <?php if($isOwner){?>
                    <div class="tab-pane <?=$tab=='purchases'?'active':'';?>" id="purchases">
                          <?=$this->render('_index_purchases',['purchases'=>$purchases])?>
                    </div>
                    <div class="tab-pane <?=$tab=='my_payments'?'active':'';?>" id="my-payments">
                        <?=$this->render('_index_my_payments',['my_payments'=>$my_payments])?>
                    </div>
                    <div class="tab-pane <?=$tab=='orders'?'active':'';?>" id="orders">
                          <?=$this->render('_index_orders',['orders'=>$orders])?>
                    </div>
                    <div class="tab-pane <?=$tab=='orders_payment'?'active':'';?>" id="orders-payment">
                        <?=$this->render('_index_orders_payment',['orders_payment'=>$orders_payment])?>
                    </div>
                    <div class="tab-pane <?=$tab=='establishments'?'active':'';?>" id="establishments">
                        <?=$this->render('_index_establishments',['establishments'=>$establishments,
                            'establishments_model'=>$establishments_model])?>
                    </div>
                    <?php }?>
                </div>
				<?php }*/?>
        </div>
  </div>
  <?php if(!$isOwner){?>
  <?=$this->render('_index_right',['profile'=>$profile]);?>
  <?php
	}else{
  ?>
	<div class="col-md-6 col-md-4">
		<div class="profile-img" style="display:none;">
			<?php
				$img = !empty($profile->photo)?Yii::$app->homeUrl.'pix/'.$profile->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
			?>
			<img src="<?=$img?>">
		</div>
		<div class="profile-right">
	        <h3 style="margin-bottom:20px;"><i class="fa fa-users"></i>&nbsp;My Boards</h3>
	        <div class="list-group">
				<a href="#wrapper-container" class="list-group-item text-capitalize tpage">
	                BoardFeeds
	            </a>
	            <a href="#boards" class="list-group-item text-capitalize tpage">
	                Cookboard
	            </a>
	            <a href="#purchases" class="list-group-item text-capitalize tpage">
	                Entry purchase
	            </a>
				<a href="#my-payments" class="list-group-item text-capitalize tpage">
	                Entry Payment
	            </a>
	            <a href="#orders" class="list-group-item text-capitalize tpage">
	                Board Orders
	            </a>
				<a href="#orders-payment" class="list-group-item text-capitalize tpage">
	                Received Payments
	            </a>
	            <a href="#establishments" class="list-group-item text-capitalize tpage">
	                Establishment
	            </a>
	        </div>
	    </div>
		<div class="profile-right">
			<h3><i class="fa fa-users"></i>&nbsp;Followers</h3>
			
				<?php
					foreach($item_followers as $item_follower){
							$item = $item_follower->user;
						    $metadata = [];
							if(!empty($item->userMeta)){
								foreach($item->userMeta as $meta){
									$key = $meta->meta_key;
									$value = $meta->meta_value;
									$metadata = array_merge(["$key"=>$value],$metadata);
								}
							}
							$img = empty($item->photo)?'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png':Yii::$app->homeUrl.'pix/'.$item->photo;
						?>
						
							<a title="<?=ucwords($item->slug)?>" href="<?=Yii::$app->homeUrl.$item->slug?>" class="">
								<img src="<?=$img?>" style="width:60px;height:60px" />
							</a>
						
						<?php
					}
				?>
			
		</div>
		
		<div class="profile-right">
			<h3 style="padding-top: 0px;"><i class="fa fa-envelope"></i>&nbsp;Invite Friends</h3>
			<div class="sdbtn"><a href="javascript:;" onclick="invite();" class="btn btn-primary" ><i class="fa fa-facebook"></i> Facebook </a></div>
			<div class="sdbtn"><a href="https://twitter.com/intent/tweet?button_hashtag=<?=str_replace("#","",$hastag);?>&text=Join%20us%20in%20Cookboard.com" class="twitter-hashtag-button sdbtn" data-size="large" data-related="cookboard"></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
		</div>
		
		<div class="profile-right">
			<h3><i class="fa fa-users"></i>&nbsp;New Members</h3>
				<div class="nmembers">
				<?php
					foreach($members as $item){
						    $metadata = [];
							if(!empty($item->userMeta)){
								foreach($item->userMeta as $meta){
									$key = $meta->meta_key;
									$value = $meta->meta_value;
									$metadata = array_merge(["$key"=>$value],$metadata);
								}
							}
							$img = empty($item->photo)?'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png':Yii::$app->homeUrl.'pix/'.$item->photo;
						?>
						
							<a title="<?=ucwords($item->slug)?>" href="<?=Yii::$app->homeUrl.$item->slug?>" class="">
								<img src="<?=$img?>" style="width:60px;height:60px" />
							</a>
						
						<?php
					}
				?>
				</div>
		</div>
		
	</div>
  <?php
	}
  ?>
  <div style="clear:both"></div>
</div>
<!-- end profile-container -->

<script>
  window.fbAsyncInit = function() {
	FB.init({
	  appId      : '632973666810949',
	  xfbml      : true,
	  version    : 'v2.3'
	});
  };

  (function(d, s, id){
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) {return;}
	 js = d.createElement(s); js.id = id;
	 js.src = "//connect.facebook.net/en_US/sdk.js";
	 fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   function invite(){
			   FB.ui({
	  method: 'send',
	  link: 'http://cookboard.com/<?=$profile->slug?>',
	});
   }
</script>
<script>
var gFollow;
</script>

<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/jquery.dataTables/jquery.dataTables.min.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] );
//if($canFollow){
    $this->registerJsFile(Yii::$app->homeUrl.'js/profile/follow.js',['depends' => 'yii\web\AssetBundle'] );
//}
$this->registerJs($this->render('index_js.php',['canFollow'=>$canFollow]));
?>

<?php $this->registerJsFile("//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js",['depends' => 'yii\web\AssetBundle'] ); ?>
<?php
$this->registerJs('

	jQuery(document).ready(function(){
		jQuery(\'#wrapper-container\').masonry({
			itemSelector : \'.item\'
		});
		jQuery(".wrap-item-img2 .img-cntre").imgCentering();
		
		
		jQuery(".tpage").click(function(){
			jQuery(".ttpage").removeClass("active");
			jQuery(jQuery(this).attr("href")).addClass("active");
			return false;
		});
		
	});
	
	
'
);?>