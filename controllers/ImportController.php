<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserModel;
use app\models\Import;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;
use app\models\LoginForm;

/**
 * TesterController implements the CRUD actions for Tester model.
 */
class ImportController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => ['login'],
            ],
        ];
    }

    public function actionPhpinfo()
    {
        phpinfo();
    }

	
	
	public function actionImportphoto(){
	
		
		if (!\Yii::$app->user->isGuest) {
		
			$insta_link = Yii::$app->instagramapi->instagramLogin();
			return $this->render('importphoto',['insta_link' => $insta_link]);
           
        }else{
			  Yii::$app->user->logout();
			 return $this->goHome();
		}
		
	
	
	
	}
	public function actionPinterest(){
	

       if (!\Yii::$app->user->isGuest) {
            return $this->render('pinterest', [
                'model' => $model,
            ]);
		}else{
			 Yii::$app->user->logout();
			 return $this->goHome();
		}
        
	
		

	}
	
	public function actionLink(){
	
	if (!\Yii::$app->user->isGuest) {
		$link_user = Yii::$app->request->post('link');
		$link = str_replace('/pins/','/pins',$link_user);
		$api_url = str_replace('pinterest.com','pinterestapi.co.uk',$link);
		$url = $api_url;
		Yii::$app->curlclient->get($url);
		$i = 0;
		
		$result = Yii::$app->curlclient->currentResponse('body');
		
		$res = json_decode($result,true);
		if($res != NULL){
		foreach($res["body"] as $pins){
		
			$photos[$i]=array("url"=>str_replace('192x','736x',$pins["src"]),"title"=>$pins["desc"]);
			
			//$photos['url'][$i] = str_replace('192x','736x',$pins["src"]);
			//$photos['title'][$i] = $pins["desc"];
			$i++;
		}
		$res_photos = $photos;
		}else{
			$res_photos = 0;
		
		}
		
		return $this->render('selectpinterestphotos',['res' => $res_photos]);
	}else{
		 Yii::$app->user->logout();
		 return $this->goHome();
	}
	
	
	
	}
	
	public function actionInstagram(){
	
		if (!\Yii::$app->user->isGuest) {
			//echo $_GET['code'];
			
			if(isset($_GET['code']) && $_GET['code'] != '') {
				$auth_response = Yii::$app->instagramapi->authorize($_GET['code']);
			
				
				Yii::$app->session->set('instagram-token',$auth_response->access_token);
				Yii::$app->session->set('instagram-username',$auth_response->user->username);
				Yii::$app->session->set('instagram-profile-picture',$auth_response->user->profile_picture);
				Yii::$app->session->set('instagram-user-id',$auth_response->user->id);
				Yii::$app->session->set('instagram-full-name',$auth_response->user->full_name);
				
				Yii::$app->instagramapi->access_token = Yii::$app->session->get('instagram-token');
				// Get the user data
				
				
				$user_data = Yii::$app->instagramapi->getUser(Yii::$app->session->get('instagram-user-id'));
					
				// Get the user feed
				$user_feed = Yii::$app->instagramapi->getUserRecent(Yii::$app->session->get('instagram-user-id'));
			}
			else if(Yii::$app->session->get('instagram-token')){
						Yii::$app->instagramapi->access_token = Yii::$app->session->get('instagram-token');
						// Get the user data
						$user_data = Yii::$app->instagramapi->getUser(Yii::$app->session->get('instagram-user-id'));
					
						// Get the user feed
						$user_feed = Yii::$app->instagramapi->getUserRecent(Yii::$app->session->get('instagram-user-id'));
					}
			return $this->render('selectinstagramphotos',['user_feed' => $user_feed,
			'user_data' => $user_data
			]);
		}else{
			
			Yii::$app->user->logout();
			return $this->goHome();
		
		}
	}
	
	public function actionFacebook(){

		$serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('import/facebook'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    //insert user if not exist
                    $cuser = $eauth->getAttributes();

					var_dump($cuser);
					exit;
                    $user = UserModel::find()
                        ->where(['username' => $cuser['name']])
                        ->one();
                    if(empty($user)){
                        $user = new UserModel();
                        $user->username = $cuser['name'];
                        $user->password = $cuser['name'];
                        if(isset($cuser['email'])){
                                $user->email = $cuser['email'];
                        }else{
                                $user->notes = 'email data unavailable';
                        }
                        $user->save();
                    }

                    $identity = User::findByEAuth($eauth,$user->id);
                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    //$eauth->redirect();
                }
                else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            }
            catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
//				$eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        $model = new LoginForm();
        if ($model->load($_POST) && $model->login()) {
            return $this->goBack();
        }
        else {
            return $this->render('selectfacebookalbums', array(
                    'cuser' => $cuser,
            ));
        }

	}
	
	public function actionFacebookphotos(){
	
	
		return $this->render('selectfacebookphotos');
		
	
	}
	
	
	
}
