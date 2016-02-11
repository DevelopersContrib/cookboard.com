<?php
    if($item->user!==null){
?>
<div id="entry-<?=$item->id;?>" data-title='<?=ucwords($item->name)?>' class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca">
    <div class="wrap-cookboard-container-album wrap-cookboard-container-album-2">
        <a href="<?=Yii::$app->urlManager->createUrl(['cookboard/details', 'slug' => $item->slug])?>" class="wrap-block wcca-alink">
            <div class="wrap-block wcca-img-featured">                
                <?php
                    $img = '<div class="no-upload-img">
                            <img id="pic-'.$item->id.'" src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png" alt="no image upload" class="img-responsive">
                        </div>';
                    $img_ = '';
                    
                    foreach($item->items as $item_){
                        if(!empty($item_->board_entry_id)){
                            $entry = $item_->boardEntry;
                        }else if(!empty($item_->pin_board_entry_id)){
                            $entry = $item_->pinBoardEntry;
                        }

                        $photos = $entry->boardEntryPhoto;
                              
                        if(count($photos)>0){
                            $img = $photos[0];
                            $img = $img->external?$img->photo:Yii::$app->homeUrl.$img->photo;
                            $img_ = '<img id="pic-'.$item->id.'" src="'.$img.'" alt="" class="img-responsive">';
                            break;
                        }
                    }
                    
                    /*$photos = [];
                    if($item->board_count>0){
                        foreach($item->boardEntry as $entry){
                            $photos = $entry->boardEntryPhoto;
                              
                            if(count($photos)>0){
                                $img = $photos[0];
                                $img = $img->external?$img->photo:Yii::$app->homeUrl.$img->photo;
                                $img_ = '<img id="pic-'.$item->id.'" src="'.$img.'" alt="" class="img-responsive">';
                                break;
                            }
                        }
                    }
                    
                    if(empty($img_)){//get photo from pinned entry
                        $pins = $item->cookBoardPin;                
                        if(count($pins)>0){
                            foreach($pins as $pin){
                                $photos = $pin->boardEntry->boardEntryPhoto;
                                if(count($photos)>0){
                                    $photo = $photos[0];
                                    $img = $photo->external?$photo->photo:Yii::$app->homeUrl.$photo->photo;
                                    $img = '<img src="'.$img.'" alt="'.$pin->boardEntry->name.'" class="img-responsive">';
                                    break;
                                }
                            }
                        }
                    }
                    */
                    $img = !empty($img_)?$img_:$img;
                    
                    echo $img;
                ?>
            </div>
            <div class="wcca-header wrap-block">
                <span class="ellipsis wrap-block wcca-title text-capitalize">
                    <?=ucwords($item->name)?>
                </span>
            </div>
            <div class="wrap-block wcca-pins">
                <i class="fa fa-picture-o"></i> (<?=count($item->items)?>) entries
                <?php
                    /*if(!Yii::$app->user->isGuest && $item->user_id !== Yii::$app->user->getId()){
                        if(!$item->isPinned()){
                ?>
                <button id="<?=$item->id?>" class="btn btn-warning btn-xs pull-right pin-btn" title="Pin this board.">
                    <i class="fa fa-cutlery"></i>
                </button>
                    <?php }} */?>
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