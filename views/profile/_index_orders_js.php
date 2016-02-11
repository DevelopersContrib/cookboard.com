gIndexOrdersModal = Object.create(Cookboard.IndexOrdersModal);
gIndexOrdersModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexOrdersModal.init('orders-modal');

gIndexOrdersAddPaymentModal = Object.create(Cookboard.IndexOrdersAddPaymentModal);
gIndexOrdersAddPaymentModal.baseUrl = '<?=Yii::$app->homeUrl?>';
gIndexOrdersAddPaymentModal.init('orders-add-payment-modal');

gIndexOrders = Object.create(Cookboard.IndexOrders);
gIndexOrders.baseUrl = '<?=Yii::$app->homeUrl?>';

gIndexOrders.init('orders');