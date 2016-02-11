
<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post">-->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<!--<input type="hidden" name="cmd" value="_xclick">-->
<input type="hidden" name="business" value="kjcastanos@gmail.com">
<input type="hidden" name="item_name" value="Cookboard Items">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" value="1.00">


<input type="hidden" name="return" value="<?=Yii::$app->urlManager->createAbsoluteUrl('ipn/index')?>">
<input type="hidden" name="cancel_return" value="<?=Yii::$app->urlManager->createAbsoluteUrl('checkout/index')?>">


<input type="hidden" name="cmd" value="_ext-enter">
<input type="hidden" name="redirect_cmd" value="_xclick">

<input type="hidden" name="email" value="tester@cookboard.com">
<input type="hidden" name="first_name" value="tester">
<input type="hidden" name="last_name" value="tester lastname">
<input type="hidden" name="address1" value="davao">
<input type="hidden" name="city" value="city">
<input type="hidden" name="zip" value="8000">
<input type="hidden" name="custom" value="123123">
<input type="hidden" name="notify_url" value="<?=Yii::$app->urlManager->createAbsoluteUrl('ipn/notify')?>"> 

<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>



<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post">-->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<!--<input type="hidden" name="cmd" value="_xclick">-->
<input type="hidden" name="business" value="kjcastanos@gmail.com">
<!--<input type="hidden" name="item_name" value="Cookboard Items">-->
<input type="hidden" name="currency_code" value="USD">
<!--<input type="hidden" name="amount" value="1.00">-->


<input type="hidden" name="return" value="<?=Yii::$app->urlManager->createAbsoluteUrl('ipn/index')?>">
<input type="hidden" name="cancel_return" value="<?=Yii::$app->urlManager->createAbsoluteUrl('checkout/index')?>">

<input type="hidden" name="cmd" value="_cart">

<input type="hidden" name="upload" value="1">

<input type="hidden" name="item_name_1" value="item 1">
<input type="hidden" name="item_number_1" value="1">
<input type="hidden" name="amount_1" value="2">
<input type="hidden" name="on0_1" value="5">
<input type="hidden" name="quantity_1" value="1">

<input type="hidden" name="item_name_2" value="item 2">
<input type="hidden" name="item_number_2" value="2">
<input type="hidden" name="amount_2" value="2">
<input type="hidden" name="on0_2" value="6">
<input type="hidden" name="quantity_2" value="2">

<input type="hidden" name="item_name_3" value="item 3">
<input type="hidden" name="item_number_3" value="3">
<input type="hidden" name="amount_3" value="2">
<input type="hidden" name="on0_3" value="7">
<input type="hidden" name="quantity_3" value="3">

<input type="hidden" name="redirect_cmd" value="_xclick">

<input type="hidden" name="email" value="tester@cookboard.com">
<input type="hidden" name="first_name" value="tester">
<input type="hidden" name="last_name" value="tester lastname">
<input type="hidden" name="address1" value="davao">
<input type="hidden" name="city" value="city">
<input type="hidden" name="zip" value="8000">


<input type="hidden" name="custom" value="123123">
<input type="hidden" name="notify_url" value="<?=Yii::$app->urlManager->createAbsoluteUrl('ipn/notify')?>"> 

<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>