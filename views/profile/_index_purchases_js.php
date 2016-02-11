gIndexPurchasesModal = Object.create(Cookboard.IndexPurchasesModal);
gIndexPurchasesModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexPurchasesModal.init('purchases-modal');

gIndexPurchases = Object.create(Cookboard.IndexPurchases);
gIndexPurchases.baseUrl = '<?=Yii::$app->homeUrl?>';

gIndexPurchases.init('purchases');