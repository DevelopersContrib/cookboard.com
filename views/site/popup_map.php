<?php
//app\assets\JqueryuiAsset::register($this);
$this->registerCssFile(Yii::$app->homeUrl."css/cook-profile.css",['depends' => 'app\assets\AppAsset']);

$this->registerCss('');

$metadata = [];
if(!empty($profile->userMeta)){
    foreach($profile->userMeta as $meta){
        $key = $meta->meta_key;
        $value = $meta->meta_value;
        $metadata = array_merge(["$key"=>$value],$metadata);
    }
}
?>

<div id="profile-details" class="form-inline" >
    <ul class="list-group">
        <li class="list-group-item">
                    <label>
                      Location
                    </label>
              <div class="form-group">
                    <label class="sr-only">Location</label>
                    <input disabled type="text" class="form-control" style="width:210%" id="location" name="location" placeholder="" value="<?=!empty($metadata['location'])?$metadata['location']:'';?>">
                    <input type="hidden" class="form-control" id="latlng" name="latlng" value="<?=!empty($metadata['latlng'])?$metadata['latlng']:'';?>">
                    
              </div>
                
      </li>
      <li class="list-group-item">
          <div id="latlongmappopup" style="width:100%; height:200px;"></div>
          
      </li>
    </ul>    
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
    var gPopupMap;
</script>
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/site/popup_map.js',['depends' => 'app\assets\AppAsset'] ); ?>
<?php $this->registerJs($this->render('popup_map_js.php',['profile'=>$profile])); ?>

