<div class="col-xs-6 col-md-4">
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
<!--            <p class="propoints"><b>1,250</b> Pts</p>
            <p>Joined <b>7 days ago</b></p>-->
            <p class="location"><span>Location:</span> <?=$metadata['location']?></p>
            <p class="pwebsite"><b>Website:</b><a target="_blank" href="<?=$metadata['website']?>"> <?=$metadata['website']?></a></p>
            <div style="clear:both"></div>
            <div class="profile-about-me">
                    <h4>About:</h4>
                    <p><?=$metadata['about']?></p>
            </div>				
    </div>
    <div class="profile-right">
            <div class="profile-map">
                    <h3>My Location</h3>
                    <div id="map-outer" class="col-md-12">          
                            <div id="map-container" class="col-md-12"></div>
                    </div><!-- /map-outer -->
                    <div style="clear:both"></div>
            </div>
    </div>
</div>
<?php $this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_right.js',['depends' => 'yii\web\AssetBundle'] ); ?>