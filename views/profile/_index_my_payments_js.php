
gIndexMyPaymentsModal = Object.create(Cookboard.IndexMyPaymentsModal);
gIndexMyPaymentsModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexMyPaymentsModal.init('my-payments-modal');

gIndexMyPayments = Object.create(Cookboard.IndexMyPayments);
gIndexMyPayments.baseUrl = '<?=Yii::$app->homeUrl?>';

gIndexMyPayments.init('my-payments');