<?php
namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\OrdersPayment;

class IpnController extends \app\components\Safecontroller
{
    
    public function actionIndex()
    {
        $file = 'ipn.txt';
        $current = file_get_contents($file);
        $current .= "test\n";
        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                $current .= $key.'= '.$value."\n"; //create variable
            }
        }
        $current .= file_get_contents('php://input');
        file_put_contents($file, $current);
        die();
    }

	public function actionAndroid(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return json_encode(['test'=>'123']);
	}
	
    public function actionTest()
    {
		$postdata = file_get_contents("php://input");
		var_dump($postdata);
		die();
        var_dump(Yii::$app->params['paypal_url']);
        $identity = Yii::$app->getUser()->getIdentity();
        
        echo '<pre>';
        print_r($identity);
        echo '</pre>';
        
        echo '<pre>';
        print_r(Yii::$app->user);
        echo '</pre>';
        
        echo '<pre>';
        print_r(Yii::$app->getUser());
        echo '</pre>';
        
    }
    
    public function actionUpgrade()
    {
        // CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
        // Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
        // Set this to 0 once you go live or don't require logging.
        define("DEBUG", 1);
        // Set to 0 once you're ready to go live
        define("USE_SANDBOX", 1);
        define("LOG_FILE", "./ipn.log");
        // Read POST data
        // reading posted data directly from $_POST causes serialization
        // issues with array data in POST. Reading raw POST data from input stream instead.
        $raw_post_data = file_get_contents('php://input');

        $now = time();
        file_put_contents($now.'.txt', $raw_post_data);

        
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
                $keyval = explode ('=', $keyval);
                if (count($keyval) == 2)
                        $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
                if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                        $value = urlencode(stripslashes($value));
                } else {
                        $value = urlencode($value);
                }
                $req .= "&$key=$value";
        }
        // Post IPN data back to PayPal to validate the IPN data is genuine
        // Without this step anyone can fake IPN data
        if(USE_SANDBOX == true) {
                $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
                $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
        }
        
        $paypal_url = Yii::$app->params['paypal_url'];
        
        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
                return FALSE;
        }


        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        /*if(DEBUG == true) {
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }*/

        // CONFIG: Optional proxy configuration
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        // CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        // of the certificate as shown below. Ensure the file is readable by the webserver.
        // This is mandatory for some environments.
        //$cert = __DIR__ . "./cacert.pem";
        //curl_setopt($ch, CURLOPT_CAINFO, $cert);
        $res = curl_exec($ch);
        //var_dump($res);

        /*
        $file = 'ipn.txt';
        $current = file_get_contents($file);
        $current .= "test\n";

        $current .= "res: ".$res."\n";

        file_put_contents($file, $current);
        */

        if (curl_errno($ch) != 0) // cURL error
                {
                if(DEBUG == true) {	
                        error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
                }
                curl_close($ch);
                exit;
        } else {
            // Log the entire HTTP response if debug is switched on.
            /*if(DEBUG == true) {
                    error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                    error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
                    // Split response headers and payload
                    list($headers, $res) = explode("\r\n\r\n", $res, 2);
            }*/
            curl_close($ch);


        }
        /*
        $file = 'ipn.txt';
        $current = file_get_contents($file);
        $current .= "test\n";

        $current .= "res: ".$res."\n";
        $current .= "strcmp: ".strcmp ($res, "VERIFIED")."\n";
        file_put_contents($file, $current);
        */
        // Inspect IPN validation result and act accordingly
        if (strcmp ($res, "VERIFIED") == 0) {

                // check whether the payment_status is Completed
                // check that txn_id has not been previously processed
                // check that receiver_email is your PayPal email
                // check that payment_amount/payment_currency are correct
                // process payment and mark item as paid.
                // assign posted variables to local variables
                //$item_name = $_POST['item_name'];
                //$item_number = $_POST['item_number'];
                //$payment_status = $_POST['payment_status'];
                //$payment_amount = $_POST['mc_gross'];
                //$payment_currency = $_POST['mc_currency'];
                //$txn_id = $_POST['txn_id'];
                //$receiver_email = $_POST['receiver_email'];
                //$payer_email = $_POST['payer_email'];

                //$file = 'ipn.txt';
                //$current = file_get_contents($file);
                //$current .= "test\n";
                //$current .= $_POST['custom']."\n";

               // $current .= "orderid: ".$order_id."\n";
                //$current .= "result: ".$res."\n";

                //file_put_contents($file, $current);

            $custom = json_decode($_POST['custom']);
            $userid = $custom->payment_from;

            if($_POST['payment_status']=='Completed'){

                $user = \app\models\UserModel::findOne($userid);
                $user->type = \app\models\UserModel::PREMIUM;
                $user->save();

                $txn_id = $_POST['txn_id'];
                
                $payer_email = $_POST['payer_email'];

                if(\app\models\UpgradePayment::findOne([
                    'payer_email' =>$payer_email,
                    'txn_id' =>$txn_id,
                    'payment_from' =>$userid
                ])===null){

                    $payment = new \app\models\UpgradePayment();

                    $payment->amount = $_POST['mc_gross'];
                    $payment->status = $_POST['payment_status'];
                    $payment->payer_email = $_POST['payer_email'];
                    $payment->summary = implode(':::', $_POST);

                    $payment->payment_from = $custom->payment_from;
                    $payment->txn_id = $txn_id;
                    $payment->save();

                }
                
            }
                if(DEBUG == true) {
                        error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
                }
        } else if (strcmp ($res, "INVALID") == 0) {
                // log for manual investigation
                // Add business logic here which deals with invalid IPN messages
                if(DEBUG == true) {
                        error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
                }
        }
    }
	public function actionNotify()
	{
		// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
		// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
		// Set this to 0 once you go live or don't require logging.
		define("DEBUG", 1);
		// Set to 0 once you're ready to go live
		define("USE_SANDBOX", 1);
		define("LOG_FILE", "./ipn.log");
		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		
                $now = time();
                file_put_contents($now.'.txt', $raw_post_data);
                
		/*
		$file = 'notify.txt';
                $current = file_get_contents($file);
                $current .= "test\n";
                if(!empty($_POST)){
                    foreach($_POST as $key => $value){
                        $current .= $key.'= '.$value."\n"; //create variable
                    }
                }
                $current .= $raw_post_data;
                file_put_contents($file, $current);
		*/
		
		/*$file = 'ipn.txt';
                $current = file_get_contents($file);
                $current .= "test\n";
                $current .= $_POST['custom']."\n";
                
                $custom = json_decode($_POST['custom']);
                $order_id = $custom->order_id;
                $current .= "orderid: ".$order_id."\n";
                
                $orders = Orders::findOne($order_id);
                $orders->status = Orders::STATUS_PAID;
                $res = $orders->save();
                
                $current .= "status: ".$orders->status."\n";
                $current .= "res: ".$res."\n";
                
                file_put_contents($file, $current);
                
                */
                
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}
		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data
		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}
                $paypal_url = Yii::$app->params['paypal_url'];
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}

		
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
                
		/*if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}*/
                
		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.
		//$cert = __DIR__ . "./cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);
		$res = curl_exec($ch);
		//var_dump($res);
                
                /*
                $file = 'ipn.txt';
                $current = file_get_contents($file);
                $current .= "test\n";
                
                $current .= "res: ".$res."\n";
                
                file_put_contents($file, $current);
                */
                
		if (curl_errno($ch) != 0) // cURL error
			{
			if(DEBUG == true) {	
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;
		} else {
                    // Log the entire HTTP response if debug is switched on.
                    /*if(DEBUG == true) {
                            error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                            error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
                            // Split response headers and payload
                            list($headers, $res) = explode("\r\n\r\n", $res, 2);
                    }*/
                    curl_close($ch);
                    
                    
		}
                /*
                $file = 'ipn.txt';
                $current = file_get_contents($file);
                $current .= "test\n";
                
                $current .= "res: ".$res."\n";
                $current .= "strcmp: ".strcmp ($res, "VERIFIED")."\n";
                file_put_contents($file, $current);
                */
		// Inspect IPN validation result and act accordingly
		if (strcmp ($res, "VERIFIED") == 0) {
                    
			// check whether the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment and mark item as paid.
			// assign posted variables to local variables
			//$item_name = $_POST['item_name'];
			//$item_number = $_POST['item_number'];
			//$payment_status = $_POST['payment_status'];
			//$payment_amount = $_POST['mc_gross'];
			//$payment_currency = $_POST['mc_currency'];
			//$txn_id = $_POST['txn_id'];
			//$receiver_email = $_POST['receiver_email'];
			//$payer_email = $_POST['payer_email'];
                        
			//$file = 'ipn.txt';
                        //$current = file_get_contents($file);
                        //$current .= "test\n";
                        //$current .= $_POST['custom']."\n";
                        
                       // $current .= "orderid: ".$order_id."\n";
                        //$current .= "result: ".$res."\n";
                        
                        //file_put_contents($file, $current);
                        
                    $custom = json_decode($_POST['custom']);
                    $order_id = $custom->order_id;
                        
                    if($_POST['payment_status']=='Completed'){

                        $orders = Orders::findOne($order_id);
                        $orders->payment_status = Orders::PAID;
                        $result = $orders->save();
                        
                        $txn_id = $_POST['txn_id'];
                        $receiver_email = $_POST['receiver_email'];
                        $payer_email = $_POST['payer_email'];
                        
                        if(OrdersPayment::findOne([
                            'receiver_email' =>$receiver_email,
                            'payer_email' =>$payer_email,
                            'txn_id' =>$txn_id,
                            'orders_id' =>$orders_id
                        ])===null){
                        
                            $payment = new OrdersPayment();

                            $payment->orders_id = $orders->id;
                            $payment->amount = $_POST['mc_gross'];
                            $payment->status = $_POST['payment_status'];
                            $payment->payer_email = $_POST['payer_email'];
                            $payment->receiver_email = $_POST['receiver_email'];
                            $payment->summary = implode(':::', $_POST);
                            
                            $payment->payment_type = OrdersPayment::PAYPAL;
                            
                            $payment->payment_from = $custom->payment_from;
                            $payment->payment_to = $custom->payment_to;
                            $payment->txn_id = $txn_id;
                            $payment->save();
                            
                        }
                        //$file = 'ipn.txt';
                        //$current = file_get_contents($file);
                        //$current .= "test\n";
                        //$current .= "result: $result ";
                        //file_put_contents($file, $current);
                        
                        //$entries = $custom['entries'];
                        /*if (!Yii::$app->getSession()->has('cart')) {
                            $cart = Yii::$app->getSession()->get('cart');
                            foreach($entries as $entry){
                                unset($cart[$entry]);
                            }
                            Yii::$app->getSession()->set('cart', $cart);
                        }*/
                    }
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
			}
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
			}
		}
	}
	
	public function actionNotify1()
    {
        // Response from Paypal
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}

		// assign posted variables to local variables
		$data['item_name']          = $_POST['item_name'];
		$data['item_number']        = $_POST['item_number'];
		$data['payment_status']     = $_POST['payment_status'];
		$data['payment_amount']     = $_POST['mc_gross'];
		$data['payment_currency']   = $_POST['mc_currency'];
		$data['txn_id']             = $_POST['txn_id'];
		$data['receiver_email']     = $_POST['receiver_email'];
		$data['payer_email']        = $_POST['payer_email'];
		$data['custom']             = $_POST['custom'];
		$data['invoice']            = $_POST['invoice'];
		$data['paypallog']          = $req;

		// post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

		if (!$fp) {
			// HTTP ERROR
			echo "error ftp";
			var_dump($fp);
		} else {  
			
			$res=stream_get_contents($fp, 1024);
			var_dump($res);
			/*
			fputs ($fp, $header . $req);
			while (!feof($fp)) {
				////mail('atiftariq80@gmail.com','Step 9','Step 9');        
				$res = fgets ($fp, 1024);
				var_dump($res);
				if (true || strcmp($res, "VERIFIED") == 0) {
					////mail('atiftariq80@gmail.com','PAYMENT VALID','PAYMENT VALID');  

					// Validate payment (Check unique txnid & correct price)
					$valid_txnid = check_txnid($data['txn_id']);
					$valid_price = check_price($data['payment_amount'], $data['item_number']);
					// PAYMENT VALIDATED & VERIFIED!
					
					var_dump($valid_txnid,$valid_price);
					
					if($valid_txnid && $valid_price){               
					//----------------- INSERT RECORDS TO DATABASE-------------------------------------
					if ($data['invoice']=='basic') {
						$price = 39;
					} else { 
						$price = 159;
					}
					$this->user_model->update_user(
						array(
							'id' => $data['custom'],
							'user_status' => 1,
							'payment_date' => date("Y-m-d H:i:s",time()),
							'next_payment_date' => date('Y-m-d', strtotime('+32 days')),
							'user_package' => $data['invoice'],
							'package_price' => $price
						)
					);
					$data2 = array('id' => '',
					'txn_id' => $data['txn_id'],
					'amount' => $data['payment_amount'],
					'mode ' => $data['payment_status'],
					'paypal_log' => $data['paypallog'],
					'user_id' => $data['custom'],
					'created_at' => date('Y-m-d H:i:s',time())

					);
					$this->db->insert('tbl_paypal_log', $data2);
					//----------------- INSERT RECORDS TO DATABASE-------------------------------------
					}else{                  
					// Payment made but data has been changed
					// E-mail admin or alert user
					}                      

				} elseif ($res=='INVALID') {

					// PAYMENT INVALID & INVESTIGATE MANUALY! 
					// E-mail admin or alert user
					////mail('atiftariq80@gmail.com','PAYMENT INVALID AND INVESTIGATE MANUALY','PAYMENT INVALID AND INVESTIGATE MANUALY');  

				}       
			}       */ 
			fclose ($fp);
		}
    }
}
