
gIndexOrdersPaymentModal = Object.create(Cookboard.IndexOrdersPaymentModal);
gIndexOrdersPaymentModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexOrdersPaymentModal.init('orders-payment-modal');

gIndexOrdersPayment = Object.create(Cookboard.IndexOrdersPayment);
gIndexOrdersPayment.baseUrl = '<?=Yii::$app->homeUrl?>';

gIndexOrdersPayment.init('orders-payment');