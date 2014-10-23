<?php
    $photo = !empty($profile->photo)?Yii::$app->homeUrl.'pix/'.$profile->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
?>
gDetails = Object.create(Cookboard.Details);
gDetails.uploadUrl = '<?=Yii::$app->urlManager->createUrl(['boardentry/upload']);?>';
gDetails.baseUrl = '<?=Yii::$app->homeUrl?>';
gDetails.photo = '<?=$photo;?>';
gDetails.init('profile-details');