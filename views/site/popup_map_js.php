<?php
    $photo = !empty($profile->photo)?Yii::$app->homeUrl.'pix/'.$profile->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
?>
gPopupMap = Object.create(Cookboard.Popupmap);
gPopupMap.baseUrl = '<?=Yii::$app->homeUrl?>';

gPopupMap.address = address;
gPopupMap.defaultlatlng = defaultlatlng;

gPopupMap.init('');