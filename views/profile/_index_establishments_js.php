
gIndexEstablishmentsModal = Object.create(Cookboard.IndexEstablishmentsModal);
gIndexEstablishmentsModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexEstablishmentsModal.uploadUrl = '<?=Yii::$app->urlManager->createUrl(['boardentry/upload']);?>';
gIndexEstablishmentsModal.init('establishments-modal');


gIndexEstablishments = Object.create(Cookboard.IndexEstablishments);
gIndexEstablishments.baseUrl = '<?=Yii::$app->homeUrl?>';

gIndexEstablishments.init('establishments');