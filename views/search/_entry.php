<?php
    if($item->cookboard!==null && $item->user!==null){
?>
<div id="entry-<?=$item->id;?>" data-title='<?=ucwords($item->name)?>' class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca">
    <?php
            if($item->post_type === app\models\BoardEntry::POST_TYPE_FOR_SALE){
        ?>
        <div class="ribbon-wrapper-orange"><div class="ribbon-orange">For Sale!</div></div>
        <?php
            }
        ?>
    <div class="wrap-cookboard-container-album wrap-cookboard-container-album-2">        
        <a href="<?=Yii::$app->urlManager->createUrl(['boardentry/details', 'cookboard'=> $item->cookboard->slug, 'slug' => $item->slug])?>" class="wrap-block wcca-alink">
            <div class="wrap-block wcca-img-featured">                
                <?php
                    $img = '<div class="no-upload-img">
                            <img id="pic-'.$item->id.'" src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png" alt="no image upload" class="img-responsive">
                        </div>';

                    $photos = $item->boardEntryPhoto;
                    if(count($photos)>0){
                        $img = $photos[0];
						foreach($photos as $p){
							if($p->featured==1){
								$img = $p;
								break;
							}
						}
                        $img = $img->external?$img->photo:Yii::$app->homeUrl.$img->photo;
                        $img = '<img id="pic-'.$item->id.'" src="'.$img.'" alt="no image upload" class="img-responsive">';
                    }
                    echo $img;
                ?>
            </div>
            <div class="wcca-header wrap-block">
                <span class="ellipsis wrap-block wcca-title text-capitalize">
                    <?=ucwords($item->name)?>
                </span>
            </div>
            <div class="wrap-block wcca-pins">
                <i class="fa fa-picture-o"></i> (<?=count($photos)?>) pictures
                <?php
                    if(!Yii::$app->user->isGuest && $item->user_id !== Yii::$app->user->getId()){
                        if(!$item->isPinned()){
                ?>
                <button id="<?=$item->id?>" class="btn btn-warning btn-xs pull-right pin-btn" title="Pin this board.">
                    <i class="fa fa-cutlery"></i>
                </button>
                    <?php }}?>
            </div>
            <div class="wrap-block wcca-pins">
                <div class="pull-left">
                    <?php
                        $user_photo = empty($item->user->photo)?'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png':Yii::$app->homeUrl.'pix/'.$item->user->photo;
                    ?>
                    <img class="img-responsive img-circle wrap-item-img-user wrap-item-img-user-2" src="<?=$user_photo;?>">
                </div>
                <div class="wrap-item-user-info">
                    <span class="text-lightBlck">
                        Uploaded by
                    </span>
                    <span class="text-capitalize wrap-item-user-name">
                         <?=$item->user->username;?>
                    </span>
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<?php }?>