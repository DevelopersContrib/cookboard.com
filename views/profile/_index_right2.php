<div class="col-md-6 col-md-4">
    <div class="profile-right">
            <div class="profile-img">
                <?php
                    $img = !empty($profile->photo)?Yii::$app->homeUrl.'pix/'.$profile->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                    
                    $metadata = [];
                    if(!empty($profile->userMeta)){
                        foreach($profile->userMeta as $meta){
                            $key = $meta->meta_key;
                            $value = $meta->meta_value;
                            $metadata = array_merge(["$key"=>$value],$metadata);
                        }
                    }
                ?>
                <img src="<?=$img?>">
            </div>
            <h5><a href="javascript:;"><?=$profile->username?></a></h5>
            <p class="location"><span>Location:</span> <?=!empty($metadata['location'])?$metadata['location']:'';?></p>
            <p class="pwebsite"><b>Website:</b><a target="_blank" href="<?=!empty($metadata['website'])?$metadata['website']:''?>"> <?=!empty($metadata['website'])?$metadata['website']:''?></a></p>
            <div style="clear:both"></div>
            <div class="profile-about-me">
                    <h4>About:</h4>
                    <p><?=!empty($metadata['about'])?$metadata['about']:''?></p>
            </div>				
    </div>
    <?php if(!empty($metadata['location']) || !empty($metadata['latlng'])){?>
    <div class="profile-right">
            <div class="profile-map">
                    <h3>My Location</h3>
                    <div id="map-outer" class="col-md-12">          
                            <div id="map-container" class="col-md-12"></div>
                    </div><!-- /map-outer -->
                    <div style="clear:both"></div>
            </div>
    </div>
    <?php }?>
</div>
<?php 
    if(!empty($metadata['location']) || !empty($metadata['latlng'])){
        $this->registerJsFile(Yii::$app->homeUrl.'js/site/map.js',['depends' => 'yii\web\AssetBundle'] );
        $this->registerJs($this->render('_index_right_js.php',['metadata'=>$metadata])); 
    }
?>
