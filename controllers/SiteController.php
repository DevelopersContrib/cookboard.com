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

    public function actionIndex()
    {
        $this->layout = 'home';
        $cookboard = \app\models\CookBoard::find()
            ->where('board_count > :c', [':c' => 0])->all();
        return $this->render('index',[
            'cookboard'=>$cookboard,
            //'cuisine'=> Cuisine::find()->all(),
            //'course'=> Course::find()->all()
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    //insert user if not exist
                    $cuser = $eauth->getAttributes();

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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
	
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionTest()
    {
        
        var_dump(Yii::$app->user->getId());
        echo '<br>';
        $identity = Yii::$app->getUser()->getIdentity();
        echo '<pre>';
        print_r($identity);
        echo '</pre>';
        var_dump($identity->username);
    }
}
