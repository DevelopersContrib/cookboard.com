<h3><?=$model->name?> location:</h3>
<div id="map-container" class="wrap-googlemapsContainer" style="width:600px;height: 400px"></div>
<?php
$metadata = [];
if(!empty($model->user->userMeta)){
	foreach($model->user->userMeta as $meta){
		$key = $meta->meta_key;
		$value = $meta->meta_value;
		$metadata = array_merge(["$key"=>$value],$metadata);
	}
}
if(!empty($metadata['location']) || !empty($metadata['latlng'])){
	$this->registerJsFile(Yii::$app->homeUrl.'js/site/map.js',['depends' => 'app\assets\AppAsset'] );
	$this->registerJs($this->render('details_map_js.php',['metadata'=>$metadata])); 
}
?>