<?php
namespace app\controllers;

use Yii;

class PaypalController extends \yii\web\Controller
{
    public $amount = 19.00;
	
    public function actionIndex()
    {
        return $this->render('index');
    }
		
    public function actionBuy(){
        // set 
        $paymentInfo['Order']['theTotal'] = $this->amount;
        $paymentInfo['Order']['description'] = "Some payment description here";
        $paymentInfo['Order']['quantity'] = '1';
        Yii::$app->Paypal->apiUsername = 'row.none_api1.gmail.com';
        Yii::$app->Paypal->apiPassword = 'ZQYDPZ8ZP2TLTJNK';
        Yii::$app->Paypal->apiSignature = 'Afr7z7iBpzqRfZrU7G7Sa03nvw2CACebEJqyD.UQfXJcqj6KM2Ahd8Gl';
        // call paypal 
        $result = Yii::$app->Paypal->SetExpressCheckout($paymentInfo); 
        var_dump($result);
        //Detect Errors 
        if(!Yii::$app->Paypal->isCallSucceeded($result)){ 
            if(Yii::$app->Paypal->apiLive === true){
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            }else{
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            var_dump($error);
            Yii::$app->end();

        }else { 
            // send user to paypal 
            $token = urldecode($result["TOKEN"]); 
            $payPalURL = Yii::$app->Paypal->paypalUrl.$token; 
            return $this->redirect($payPalURL); 
        }
    }

    public function actionConfirm()
    {
            $token = trim($_GET['token']);
            $payerId = trim($_GET['PayerID']);

            $result = Yii::$app->Paypal->GetExpressCheckoutDetails($token);

            $result['PAYERID'] = $payerId; 
            $result['TOKEN'] = $token; 
            $result['ORDERTOTAL'] = $this->amount;

            if (!Yii::$app->user->isGuest){
                    $Payment=new Payment;
                    $Payment->contractor_id = Yii::$app->user->getId();			
                    $Payment->token = $token;
                    $Payment->firstname = $result['FIRSTNAME'];
                    $Payment->lastname = $result['LASTNAME'];
                    $Payment->email = $result['EMAIL'];
            }

            //Detect errors 
            if(!Yii::$app->Paypal->isCallSucceeded($result)){ 
                    if(Yii::$app->Paypal->apiLive === true){
                            //Live mode basic error message
                            $error = 'We were unable to process your request. Please try again later';
                    }else{
                            //Sandbox output the actual error message to dive in.
                            $error = $result['L_LONGMESSAGE0'];
                    }

                    if (!Yii::$app->user->isGuest){
                            $Payment->status = 'failed';
                            $Payment->summary = json_encode(array('checkout_details'=>$result,'error'=>$error));
                            $Payment->save();
                    }

                    echo $error;
                    Yii::$app->end();
            }else{ 

                    $paymentResult = Yii::$app->Paypal->DoExpressCheckoutPayment($result);
                    //Detect errors  
                    if(!Yii::$app->Paypal->isCallSucceeded($paymentResult)){
                            if(Yii::$app->Paypal->apiLive === true){
                                    //Live mode basic error message
                                    $error = 'We were unable to process your request. Please try again later';
                            }else{
                                    //Sandbox output the actual error message to dive in.
                                    $error = $paymentResult['L_LONGMESSAGE0'];
                            }

                            if (!Yii::$app->user->isGuest){
                                    $Payment->status = 'failed';
                                    $Payment->summary = json_encode(array('checkout_details'=>$result,'payment_result'=>$paymentResult,'error'=>$error));
                                    $Payment->save();
                            }

                            echo $error;
                            Yii::$app->end();
                    }else{
                            //payment was completed successfully

                            if (!Yii::$app->user->isGuest){
                                    $contractor_id =  Yii::$app->user->getId();
                                    if (Yii::$app->Ini->isexpired($contractor_id)){
                                      $sql = "UPDATE `contractors` SET `Date_expired` =  DATE_ADD(NOW(), INTERVAL 365 DAY) WHERE ContractorId = '$contractor_id'";
                                    }else {
                                      $sql = "UPDATE `contractors` SET `Date_expired` =  DATE_ADD(Date_expired, INTERVAL 365 DAY) WHERE ContractorId = '$contractor_id'";	
                                    }
                                    $balance = Yii::$app->db->createCommand($sql);
                $data = $balance->query();

                                    $Payment->amount = $paymentResult['AMT'];
                                    $Payment->transaction_id = $paymentResult['TRANSACTIONID'];
                                    $Payment->currency = $paymentResult['CURRENCYCODE'];
                                    $Payment->status = $paymentResult['PAYMENTSTATUS'];
                                    $Payment->description = '';
                                    $Payment->summary = json_encode(array('checkout_details'=>$result,'payment_result'=>$paymentResult));
                                    $Payment->save();
                        }

                            return $this->render('confirm');
                    }

            }
	}
        
    public function actionCancel()
	{
		//The token of the cancelled payment typically used to cancel the payment within your application
		//$token = $_GET['token'];
		return $this->render('cancel');
	}
	
	public function actionDirectPayment(){ 
		$paymentInfo = array('Member'=> 
			array( 
				'first_name'=>'name_here', 
				'last_name'=>'lastName_here', 
				'billing_address'=>'address_here', 
				'billing_address2'=>'address2_here', 
				'billing_country'=>'country_here', 
				'billing_city'=>'city_here', 
				'billing_state'=>'state_here', 
				'billing_zip'=>'zip_here' 
			), 
			'CreditCard'=> 
			array( 
				'card_number'=>'number_here', 
				'expiration_month'=>'month_here', 
				'expiration_year'=>'year_here', 
				'cv_code'=>'code_here' 
			), 
			'Order'=> 
			array('theTotal'=>1.00) 
		); 

	   // 
		// On Success, $result contains [AMT] [CURRENCYCODE] [AVSCODE] [CVV2MATCH]  
		// [TRANSACTIONID] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD] 
		//  
		// On Fail, $ result contains [AMT] [CURRENCYCODE] [TIMESTAMP] [CORRELATIONID]  
		// [ACK] [VERSION] [BUILD] [L_ERRORCODE0] [L_SHORTMESSAGE0] [L_LONGMESSAGE0]  
		// [L_SEVERITYCODE0]  
		// 
	  
		$result = Yii::$app->Paypal->DoDirectPayment($paymentInfo); 
		
		//Detect Errors 
		if(!Yii::$app->Paypal->isCallSucceeded($result)){ 
			if(Yii::$app->Paypal->apiLive === true){
				//Live mode basic error message
				$error = 'We were unable to process your request. Please try again later';
			}else{
				//Sandbox output the actual error message to dive in.
				$error = $result['L_LONGMESSAGE0'];
			}
			echo $error;
			
		}else { 
			//Payment was completed successfully, do the rest of your stuff
		}

		Yii::$app->end();
	} 
}
