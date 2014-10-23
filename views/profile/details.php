<?php
$this->registerCssFile(Yii::$app->homeUrl."css/cook-profile.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('
    .dropzone .dz-default.dz-message {
        background-image: none;
        background-position: 0 0;
        background-repeat: no-repeat;
        filter: none;
        height: 123px;
        left: 25%;
        margin-left: 1px;
        margin-top: 1px;
        opacity: 1;
        position: absolute;
        top: 1px;
        transition: opacity 0.3s ease-in-out 0s;
        width: auto;
    }
    .dropzone .dz-default.dz-message span {
        display: block;
    }
    .dropzone {
        min-height: 145px;
        width: 200px;
    }
}');

//$userMeta = Yii::$app->z->userMeta($profile->userMeta);
$metadata = [];
if(!empty($profile->userMeta)){
    foreach($profile->userMeta as $meta){
        $key = $meta->meta_key;
        $value = $meta->meta_value;
        $metadata = array_merge(["$key"=>$value],$metadata);
    }
}
?>
<!--<form id="profile-details" class="form-inline" role="form">-->
<div id="profile-details" class="form-inline" >
    <input type='hidden' name='wtets' value='' />
    <ul class="list-group">
      <li class="list-group-item">
                  <label>
                      Name
                    </label>
              <div class="form-group">
                    <label class="sr-only">Firstname</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="<?=!empty($metadata['first_name'])?$metadata['first_name']:''?>">
              </div>
              <div class="form-group">
                    <label class="sr-only">Lastname</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="<?=!empty($metadata['last_name'])?$metadata['last_name']:''?>">
              </div>
      </li>
      <li class="list-group-item">
                    <label>
                      Picture
                    </label>
             <div class="checkbox">
                    <?php 
                        $img= !empty($profile->photo)?$profile->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
                    ?>
                    <?php /*?>
                    <img style="width:100px; height: 100px" src="<?=$img?>">
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#dchange">
                      Change Picture
                    </button>
                    <div id="dchange" class="collapse out">
                            <p><b>Change your picture</b>
                            </p>
                            <div class="input-group">
                              <div class="input-group-btn">
                                    <button class="btn btn-default" type="button">Choose File</button>
                              </div>
                              <input type="text" class="form-control">
                            </div><!-- /input-group -->
                    </div>
                    <?php */?>
                    <form id="up-photo" class="form-inline dropzone dz-clickable" role="form">
                        <?=Yii::$app->z->hiddenCsrfToken()?>
                    </form>
                 <input id="profile-photo" type="hidden" value="" />
             </div>								
      </li>
      <!--<li class="list-group-item">	
                    <label>
                      Username
                    </label>
              <div class="form-group">
                    www.cookboard.com/
              </div>
              <div class="form-group">
                    <label class="sr-only">Username</label>
                    <input type="text" class="form-control" id="" placeholder="abcipriano">
              </div>
      </li>-->
      <li class="list-group-item">
                    <label>
                      About You
                    </label>
              <div class="form-group">
                    <label class="sr-only">About</label>
                    <textarea id="about" name="about" class="form-control" rows="3" style="width:190%" placeholder=""><?=!empty($metadata['about'])?$metadata['about']:'';?></textarea>
              </div>
      </li>
      <li class="list-group-item">
                    <label>
                      Location
                    </label>
              <div class="form-group">
                    <label class="sr-only">Location</label>
                    <input type="text" class="form-control" style="width:210%" id="location" name="location" placeholder="" value="<?=!empty($metadata['location'])?$metadata['location']:'';?>">
              </div>
      </li>
      <li class="list-group-item">
                    <label>
                      Website
                    </label>
              <div class="form-group">
                    <label class="sr-only">Website</label>
                    <input type="text" class="form-control" id="web_site" name="web_site" placeholder="" value="<?=!empty($metadata['website'])?$metadata['website']:'';?>">
              </div>
      </li>
    </ul>
    <!--</form>-->
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/profile/details.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('details_js.php',['profile'=>$profile])); ?>