<style>
.wrap-item {
    height: 279px;
}
</style>
<div id="board-<?=$item->id;?>" data-title='<?=ucwords($item->name)?>' class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca item board">
     <?php
            if($item->post_type === app\models\BoardEntry::POST_TYPE_FOR_SALE){
        ?>
        <div class="ribbon-wrapper-orange"><div class="ribbon-orange">For Sale!</div></div>
        <?php
            }
        ?>
    <div class="wrap-item">
        <div class="wrap-item-img wrap-item-img2">
            <?php
                //$photos = $item->boardEntryPhotoList;
                $photos = $item->boardEntryPhoto;
                $img = 'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/colored-icon.png';
                if(count($photos)>0){
                    //$img = Yii::$app->homeUrl.reset($photos);
                    $img = $photos[0];
                    
                    $img = $img->external?$img->photo:Yii::$app->homeUrl.$img->photo;
                }
            ?>
            <img class="img-responsive img-cntre" src="<?=$img;?>">
            <div class="wrap-counter-entery font-raleways">
                <?=count($photos);?> Photos
            </div>
            <div class="wrap-figCaption" title="<?=ucwords($item->name)?>">
                <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/colored-icon.png">
                <ul class="list-inline ul-wcca-btn-actions text-center">
                    <li>
                        <a href="<?=Yii::$app->urlManager->createUrl(['boardentry/details','cookboard'=> $parent_cookboard->slug,  'slug' => $item->slug]);?>" 
                           class="wcca-btn-actions wcca-btn-actions1" data-toggle="tooltip" data-placement="top" title="View Entry">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <?php //if(!Yii::$app->user->isGuest && $item->user_id === Yii::$app->user->getId()){ ?>
                    <?php if($item->canEdit()){ ?>
                    <li>
                        <a title="Edit Entry" href="<?=Yii::$app->urlManager->createUrl(['boardentry/update', 'slug' => $item->slug]);?>" 
                           class="wcca-btn-actions wcca-btn-actions2"  data-toggle="tooltip" data-placement="top">
                            <i class="fa fa-edit"></i>
                        </a>
                    </li>
                    <li>
                        <a id="<?=$item->id?>" title="Delete Entry" href="javascript:;" class="wcca-btn-actions wcca-btn-actions3 delete-entry"  data-toggle="tooltip" data-placement="top">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <ul class="list-unstyled ul-wrap-item-info">
            <li>
                <i class="fa fa-chain"></i> 
                <span class="text-capitalize">
                    <?php echo $item->name?>
                </span>
            </li>
            <?php if($item->post_type===app\models\BoardEntry::POST_TYPE_FOR_SALE){?>
            <li>
                <span class="text-capilize">
                    <!--<i class="fa fa-rub"></i>-->
                    <span class="hghlght-text font-raleways font-500">
                        <?php echo $item->priceType->name.' '.number_format($item->price,2);?>
                    </span>
                </span>
            </li>
            <?php }?>
			<?php if(!empty($item->city)){ ?>
            <li>
                <span class="text-capitalize">
                    <i class="fa fa-map-marker"></i> 
                    <?php echo $item->city?>
                </span>
            </li>
            <?php }?>
        </ul>
    </div>
</div>