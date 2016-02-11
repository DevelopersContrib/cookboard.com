<?php
    $metadata = [];
    if(!empty($item->userMeta)){
        foreach($item->userMeta as $meta){
            $key = $meta->meta_key;
            $value = $meta->meta_value;
            $metadata = array_merge(["$key"=>$value],$metadata);
        }
    }
?>
<div id="entry-<?=$item->id;?>" data-title='<?=ucwords($item->slug)?>' class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca">
    <div class="wrap-cookboard-container-album wrap-cookboard-container-album-2">
        <a href="<?=Yii::$app->homeUrl.$item->slug?>" class="wrap-block wcca-alink">
            <div class="wrap-block wcca-img-featured">                
                <?php
                    $img = empty($item->photo)?'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png':Yii::$app->homeUrl.'pix/'.$item->photo;
                    echo '<img id="pic-'.$item->id.'" src="'.$img.'" class="img-responsive">';
                ?>
            </div>
            <div class="wcca-header wrap-block">
                <span class="ellipsis wrap-block wcca-title text-capitalize">
                    <?=ucwords($item->slug)?>
                </span>
            </div>
            <div class="wrap-block wcca-pins">
                <i class="fa fa-picture-o"></i> (<?=count($item->cookboard)?>) boards
            </div>
            <?php 
                if(!empty($metadata['location'])){
            ?>
            <div class="wrap-block wcca-pins">
                <i class="fa fa-map-marker"></i> <?=$metadata['location']?>
            </div>
            <?php }?>
        </a>
    </div>
</div>
