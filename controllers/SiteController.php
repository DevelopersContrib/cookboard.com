<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserModel;
use app\models\Cuisine;
use app\models\Course;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;

class SiteController extends Controller
{
    public $layout = 'main';
    public function actions()
    {
        return array(
            'error' => array(
                'class' => 'yii\web\ErrorAction',
            ),
        );
    }

    public function behaviors() {
        return array(
            'access' => array(
                'class' => AccessControl::className(),
                'only' => array('login'),
                'rules' => array(
                    array(
                        'allow' => true,
//						'roles' => array('?'),
                    ),
                    array(
                        'allow' => false,
                        'denyCallback' => array($this, 'goHome'),
                    ),
                ),
            ),
            'eauth' => array(
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => array('login'),
            ),
        );
    }

	public function actionSitemap()
    {
        $users = \app\models\UserModel::find()
                ->orderBy('username')
                ->all();
        
        $cookboards = \app\models\CookBoard::find()
                ->orderBy('name')
                ->all();
        
        $boards = \app\models\BoardEntry::find()
                ->orderBy('name')
                ->all();
        
        return $this->render('sitemap',
                [
                    'users'=>$users,
                    'cookboards'=>$cookboards,
                    'boards'=>$boards
                ]);
    }
	
    public function actionIndex()
    {
        /*if (!Yii::$app->getSession()->has('location')) {
            $url = "http://api.hostip.info/get_json.php?ip=".$_SERVER['REMOTE_ADDR'];
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($curl);
            curl_close ($curl);

            Yii::$app->getSession()->set('location', $result);
        }*/
        
        $this->layout = 'home';
        $cookboard = \app\models\CookBoard::find()
            ->where('board_count > :c', [':c' => 0])->orderBy('id desc')->limit(20)->all();
		        
        $page = 'index';
		if(!empty($_REQUEST['old'])){
			if(Yii::$app->user->isGuest){
				
					$page = 'index_new';
				
				
				$boardEntry = new \app\models\BoardEntry();
				return $this->render($page,[
					'cities'=>$boardEntry->ByCities(15)
					//'cookboard'=>$cookboard,
					//'cuisine'=> Cuisine::find()->all(),
					//'course'=> Course::find()->all()
				]);
			}
		}
        
        return $this->render($page,[
            'cookboard'=>$cookboard,
			///'boards'=>$boards,
            //'cuisine'=> Cuisine::find()->all(),
            //'course'=> Course::find()->all()
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        
        /*if (!Yii::$app->getSession()->has('location')) {
            $url = "http://api.hostip.info/get_json.php?ip=".$_SERVER['REMOTE_ADDR'];
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($curl);
            curl_close ($curl);

            Yii::$app->getSession()->set('location', $result);
        }*/
		
		if(isset($_REQUEST['redirect'])){
			Yii::$app->session->set('user.redirect',$_REQUEST['redirect']);
		}else{
			//Yii::$app->session->set('user.redirect','');
		}
		
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);

            Yii::$app->setHomeUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('/dashboard'));
			$redirect = Yii::$app->session->get('user.redirect');
			
			if(!empty($redirect)){
				$eauth->setRedirectUrl("http://www.cookboard.com".$redirect."?gocart=1");
			}else{
				///$eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
			}
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));
			
			
            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    //insert user if not exist
                    $cuser = $eauth->getAttributes();
					//print_r($cuser); die();
					
					/*if($cuser['name'] === 'Maida Barrientos'){
						$user = UserModel::find()
							->where(['username' => $cuser['name']])
							->one();
						$user->external_id = $cuser['id'];
						$user->save();
					}*/
					
					$user = UserModel::find()
						->where(['external_id' => $cuser['id']])
						->one();
										
                    if(empty($user)){
                        $user = new UserModel();
                        $user->username = $cuser['name'];
						$user->external_id = strval($cuser['id']);
                        $user->password = $cuser['name'];
                        if(isset($cuser['email'])){
                                $user->email = $cuser['email'];
                        }else{
                                $user->notes = 'email data unavailable';
                        }
						
                        $user->save();
                        
                        $username = explode(' ',$cuser['name']);
                        
                        $usermeta = new \app\models\UserMeta();
                        $usermeta->user_id = $user->id;
                        $usermeta->meta_key = 'first_name';
                        $usermeta->meta_value = $username[0];
                        $usermeta->save();
                        
                        $usermeta = new \app\models\UserMeta();
                        $usermeta->user_id = $user->id;
                        $usermeta->meta_key = 'last_name';
                        $usermeta->meta_value = $username[1];
                        $usermeta->save();
						
						
						if(!empty($username[0]) || !empty($username[1])){
							
							$slug = trim($username[0].$username[1]);
							
							if(UserModel::findOne(['slug'=>$slug])!==null){
								$slug = $slug.'-'.$user->id;
							}
							
							$user->slug = Yii::$app->z->create_url_slug($slug);	
							$user->slug;
							$user->update();
						}
						
						//----------------------------------------------------------------------------
						$headers = array(
							'Accept: application/json',
						);
						$param = array(
							'domain'=>$_SERVER['HTTP_HOST'],
							'email'=>$cuser['email'],
							'user_ip'=>$_SERVER['REMOTE_ADDR']
						);
						$handle = curl_init();
						curl_setopt($handle, CURLOPT_URL, "http://www.api.contrib.com/forms/saveleads");
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_POST, true);
						curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param));
						$response = curl_exec($handle);
						
						//----------------------------------------------------------------------------
                    }else{
						$user = UserModel::find()
							->where(['external_id' => $cuser['id']])
							->one();
						if(!empty($user)){
							if(empty($user->email)){
								//----------------------------------------------------------------------------
								$headers = array(
									'Accept: application/json',
								);
								$param = array(
									'domain'=>$_SERVER['HTTP_HOST'],
									'email'=>$cuser['email'],
									'user_ip'=>$_SERVER['REMOTE_ADDR']
								);
								$handle = curl_init();
								curl_setopt($handle, CURLOPT_URL, "http://www.api.contrib.com/forms/saveleads");
								curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
								curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($handle, CURLOPT_POST, true);
								curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param));
								$response = curl_exec($handle);
								
								//----------------------------------------------------------------------------
							}
							$user->email = $cuser['email']; //update email
							$user->save();
						}
					}

                    $identity = User::findByEAuth($eauth,$user->id);
                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    $eauth->redirect();
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
            return $this->render('login', array(
                    'model' => $model,
            ));
        }
    }
	
	public function actionLogin2()
    {
        $this->layout = 'login';
        
        /*if (!Yii::$app->getSession()->has('location')) {
            $url = "http://api.hostip.info/get_json.php?ip=".$_SERVER['REMOTE_ADDR'];
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($curl);
            curl_close ($curl);

            Yii::$app->getSession()->set('location', $result);
        }*/

        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);

            Yii::$app->setHomeUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('/dashboard'));
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    //insert user if not exist
                    $cuser = $eauth->getAttributes();
					//print_r($cuser); die();
					
					if($cuser['name'] === 'Maida Barrientos'){
						$user = UserModel::find()
							->where(['username' => $cuser['name']])
							->one();
						$user->external_id = $cuser['id'];
						$user->save();
					}
					
					$user = UserModel::find()
						->where(['external_id' => $cuser['id']])
						->one();
										
                    if(empty($user)){
                        $user = new UserModel();
                        $user->username = $cuser['name'];
						$user->external_id = strval($cuser['id']);
                        $user->password = $cuser['name'];
                        if(isset($cuser['email'])){
                                $user->email = $cuser['email'];
                        }else{
                                $user->notes = 'email data unavailable';
                        }
						
                        $user->save();
                        
                        $username = explode(' ',$cuser['name']);
                        
                        $usermeta = new \app\models\UserMeta();
                        $usermeta->user_id = $user->id;
                        $usermeta->meta_key = 'first_name';
                        $usermeta->meta_value = $username[0];
                        $usermeta->save();
                        
                        $usermeta = new \app\models\UserMeta();
                        $usermeta->user_id = $user->id;
                        $usermeta->meta_key = 'last_name';
                        $usermeta->meta_value = $username[1];
                        $usermeta->save();
						
						
						if(!empty($username[0]) || !empty($username[1])){
							
							$slug = trim($username[0].$username[1]);
							
							if(UserModel::findOne(['slug'=>$slug])!==null){
								$slug = $slug.'-'.$user->id;
							}
							
							$user->slug = Yii::$app->z->create_url_slug($slug);	
							$user->slug;
							$user->update();
						}
						
						//----------------------------------------------------------------------------
						$headers = array(
							'Accept: application/json',
						);
						$param = array(
							'domain'=>$_SERVER['HTTP_HOST'],
							'email'=>$cuser['email'],
							'user_ip'=>$_SERVER['REMOTE_ADDR']
						);
						$handle = curl_init();
						curl_setopt($handle, CURLOPT_URL, "http://www.api.contrib.com/forms/saveleads");
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($handle, CURLOPT_POST, true);
						curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param));
						$response = curl_exec($handle);
						
						//----------------------------------------------------------------------------
                    }

                    $identity = User::findByEAuth($eauth,$user->id);
                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    $eauth->redirect();
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
            return $this->render('login2', array(
                    'model' => $model,
            ));
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
	
    public function actionAbout()
    {
        return $this->render('about');
    }

	public function actionTeam()
    {
        return $this->render('team');
    }
    
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
    
    public function actionToc()
    {
        return $this->render('toc');
    }
	
	public function actionReferral()
    {
        return $this->render('referral');
    }
	
	public function actionBlog()
    {
        return $this->render('blog');
    }
	
	public function actionPlugin()
    {
        return $this->render('plugin');
    }
    
	public function actionFb()
    {
		return $this->render('fb');
	}
        
    /*
     * AJAX Request
     */
    
    public function actionAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $action = Yii::$app->request->post('action');
		if($action =='location'){
			return $this->{Yii::$app->z->method($action)}($_POST);
		}
        if(method_exists(__CLASS__, Yii::$app->z->method($action)) && !\Yii::$app->user->isGuest)
            return $this->{Yii::$app->z->method($action)}($_POST);
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function location()
    {
        if (!Yii::$app->getSession()->has('location')) {
            $url = "http://api.hostip.info/get_json.php?ip=".$_SERVER['REMOTE_ADDR'];
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($curl);
            curl_close ($curl);
			
            Yii::$app->getSession()->set('location', $result);
			
			$location = json_decode($location);
			$country = '';
			$city = '';
			if(!empty($location->city)){
				$country = $location->country_name;
				$city = $location->city;
			}

			return array('country'=>$country,'city'=>$city);
        }else{
			$location = Yii::$app->getSession()->get('location');
			$location = json_decode($location);
			$country = '';
			$city = '';
			if(!empty($location->city)){
				$country = $location->country_name;
				$city = $location->city;
			}
			return array('country'=>$country,'city'=>$city);
		}
    }
        
    protected function popupmap()
    {
        $data = Yii::$app->request->post();
        if(!empty($data['profile'])){
            $profile = $this->findProfile($data['profile']);
        }else{
            $profile = $this->findProfile(Yii::$app->user->getId());
        }
        if($profile!==null){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
            return $this->renderAjax('popup_map',['profile'=>$profile]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findProfile($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionTest()
    {
		return $this->render('test');
		/*$url = "https://twitter.com/settings/account";
		$curl = curl_init(); 
		curl_setopt ($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec ($curl); 
		curl_close ($curl);  
		echo $result;
        
		die();
        var_dump(Yii::$app->user->getId());
        echo '<br>';
        $identity = Yii::$app->getUser()->getIdentity();
        echo '<pre>';
        print_r($identity);
        echo '</pre>';
        var_dump($identity->username);
		*/
    }
}
