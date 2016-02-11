<?php
//app\assets\JqueryuiAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/cook-profile.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/dropzone.css",['depends' => 'app\assets\AppAsset']);
$this->registerCss('
    .ui-autocomplete-loading {
        background: white url("'.Yii::$app->homeUrl.'img/ui-anim_basic_16x16.gif") right center no-repeat;
    }
    .ui-autocomplete{
        z-index: 9999999;
    }
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
                    <input placeholder="First Name" type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="<?=!empty($metadata['first_name'])?$metadata['first_name']:''?>">
              </div>
              <div class="form-group">
                    <label class="sr-only">Lastname</label>
                    <input placeholder="Last Name" type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="<?=!empty($metadata['last_name'])?$metadata['last_name']:''?>">
              </div>
      </li>
      <li class="list-group-item">
            <label>
              Email
            </label>
            <div class="form-group">
                  <label class="sr-only">Email Account</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?=$profile->email;?>">
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
                    
                    <form id="up-photo" class="form-inline dropzone dz-clickable" role="form">
                        <?=Yii::$app->z->hiddenCsrfToken()?>
                    </form>
                 <input id="profile-photo" type="hidden" value="" />
             </div>								
      </li>
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
                    <input type="hidden" class="form-control" id="latlng" name="latlng" value="<?=!empty($metadata['latlng'])?$metadata['latlng']:'';?>">
                    
              </div>
                
      </li>
      <li class="list-group-item">
          <div id="latlongmap" style="width:100%; height:200px;"></div>
          
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
      <li class="list-group-item">
            <label>
              PayPal Email
            </label>
            <div class="form-group">
                  <label class="sr-only">Paypal Email Account</label>
                  <input type="text" class="form-control" id="paypal_email" name="paypal_email" placeholder="" value="<?=!empty($metadata['paypal_email'])?$metadata['paypal_email']:'';?>">
            </div>
      </li>
    </ul>
    <!--</form>-->
</div>
<script>
<?php
    $loc ='';
    if(empty($metadata['location'])){
        $location = Yii::$app->getSession()->get('location');
        $location = json_decode($location);
        $loc = $location->city.', '.$location->country_name;
    }
?>

    var address = '<?=!empty($metadata['location'])?$metadata['location']:$loc;?>';
    var defaultlatlng = '<?=!empty($metadata['latlng'])?$metadata['latlng']:'';?>';
    var gDetails;
</script>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/profile/details.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('details_js.php',['profile'=>$profile])); ?>

