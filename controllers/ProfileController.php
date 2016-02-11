<?php
namespace app\controllers;

use Yii;
use app\models\UserModel;
use app\models\UserMeta;
use app\models\UserFollow;
use app\models\Orders;
use app\models\BoardEntryLike;
use app\models\CookBoard;
use app\models\Establishments;
use app\models\OrdersPayment;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

class ProfileController extends \yii\web\Controller
{
    public $layout = 'main';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'only' => ['index', 'ajax'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['ajax','upgrade'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','likes','photos','events'],
                        
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'ajax' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $tab = Yii::$app->request->get('tab');
        $userid = Yii::$app->user->getId();
        //$slug = Yii::$app->request->queryParams['slug'];
        $slug = Yii::$app->request->get('slug');
        if(!empty($slug)){
            $profile = $this->findModel(['slug'=>$slug]);
        }else{
            $profile = $this->findModel($userid);
        }
        
        $profileid = $profile->id;
        
        $establishments = Establishments::find()->where(['user_id'=>$userid])->all();
        
        $orders = Orders::find()->where(['orders_to'=>$userid])->all();
        $purchases = Orders::find()->where(['user_id'=>$userid])->all();
        
        $orders_payment = OrdersPayment::find()->where(['payment_to'=>$userid])->all();
        $my_payments = OrdersPayment::find()->where(['payment_from'=>$userid])->all();
        
        $likes = count(BoardEntryLike::findAll(['user_id'=>$profileid]));
        
        $following = count(UserFollow::findAll(['user_id'=>$profileid])); //following
        $followers = count(UserFollow::findAll(['following'=>$profileid])); //followers
        
		$follower = UserFollow::findOne(['user_id'=>$userid,'following'=>$profileid])!==null;
        $canFollow = UserFollow::findOne(['user_id'=>$userid,'following'=>$profileid])===null && 
                $userid!==$profileid;
				
		//$canFollow = !$following && $userid!==$profileid;
		
		$newMembers = $profile->getNewmembers();
		$members = [];
		foreach($newMembers as $member){
			$members[] = UserModel::findOne($member->id);
		}
		
		
		$cookboard2 = \app\models\CookBoard::find()
            ->where('board_count > :c AND user_id = :u ', [':c' => 0,':u'=>$profileid])->orderBy('id desc')->limit(20)->all();
			
        return $this->render('index',[
			'members'=>$members,
            'canFollow'=>$canFollow,
			'follower'=>$follower,
            'following'=>$following,
            'followers'=>$followers,
			'item_followers'=>UserFollow::findAll(['following'=>$profileid]),
            'likes'=>$likes,
            'isOwner'=>$profileid === $userid,
            'establishments'=>$establishments,
            'establishments_model'=>  new Establishments(),
            'orders'=>$orders,
            'my_payments'=>$my_payments,
            'purchases'=>$purchases,
            'orders_payment'=>$orders_payment,
            'tab'=>$tab,
            'profile' => $profile,
			'cookboard2'=>$cookboard2,
            'cookboard'=> Cookboard::findAll([
                'user_id' => $profileid
            ]),
        ]);
    }
    
    public function actionUpgrade()
    {
        $action = Yii::$app->request->post('action');
        $i = 1;
        if($action==='upgrade'){
            $paypal_items['item_name_'.$i] = 'Premium Account';
            $paypal_items['quantity_'.$i] = '1';
            $paypal_items['amount_'.$i] = 100;
            
            $paypal_items['business'] = Yii::$app->params['business'];
            $paypal_items['notify_url'] = Yii::$app->urlManager->createAbsoluteUrl('ipn/upgrade');
            $paypal_items['return'] = Yii::$app->urlManager->createAbsoluteUrl('site/index');
            $paypal_items['cancel_return'] = Yii::$app->urlManager->createAbsoluteUrl('profile/upgrade');
            $userid = Yii::$app->user->getId();
            $paypal_items['custom'] = json_encode([
                'payment'=>'Premium Account',
                'payment_from'=>$userid,
                ]);

            $paypal_items['cmd'] = '_cart';
            $paypal_items['upload'] = '1';

            $paypal_items_string = http_build_query($paypal_items);
            $url = Yii::$app->params['paypal_url'].'?'.$paypal_items_string;

            return Yii::$app->getResponse()->redirect($url);
        }
        return $this->render('upgrade');
    }
    
    public function actionPhotos()
    {
        return $this->render('photos');
    }
    
    public function actionEvents()
    {
        return $this->render('events');
    }
    
    public function actionLikes()
    {
        $slug = Yii::$app->request->queryParams['slug'];
        if(!empty($slug)){
            $profile = $this->findModel(['slug'=>$slug]);
            return $this->render('likes',['items'=>BoardEntryLike::findAll(['user_id'=>$profile->id]),
                'profile'=>$profile]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionFollowers()
    {
        $slug = Yii::$app->request->queryParams['slug'];
        if(!empty($slug)){
            $profile = $this->findModel(['slug'=>$slug]);
            return $this->render('followers',['items'=>  UserFollow::findAll(['following'=>$profile->id]),
                'profile'=>$profile]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionFollowing()
    {
        $slug = Yii::$app->request->queryParams['slug'];
        if(!empty($slug)){
            $profile = $this->findModel(['slug'=>$slug]);
            return $this->render('following',['items'=>UserFollow::findAll(['user_id'=>$profile->id]),
                'profile'=>$profile]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /*
     * AJAX Request
     */
    
    public function actionAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $action = Yii::$app->request->post('action');

        if(method_exists(__CLASS__, Yii::$app->z->method($action)) && !\Yii::$app->user->isGuest)
            return $this->{Yii::$app->z->method($action)}($_POST);
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function follow()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $userid = Yii::$app->user->getId();
            if(UserFollow::findOne(['user_id'=>$userid,'following'=>$data['id']])===null){
                $follow = new UserFollow();
                $follow->following = $data['id'];
                $follow->user_id = $userid;
                $status = $follow->save();
                $count = count(UserFollow::findAll(['following'=>$data['id']]));
                return ['status'=>$status,'followers'=>$count];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function unfollow()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $userid = Yii::$app->user->getId();
			$model = UserFollow::findOne(['user_id'=>$userid,'following'=>$data['id']]);
            if($model!==null){
                $status = $model->delete();
                $count = count(UserFollow::findAll(['following'=>$data['id']]));
                return ['status'=>$status,'followers'=>$count];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function details()
    {
        //$data = Yii::$app->request->post();
        $profile = $this->findModel(Yii::$app->user->getId());
        if($profile!==null){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
            return $this->renderAjax('details',['profile'=>$profile]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function save()
    {
        $data = Yii::$app->request->post();
        $userid = Yii::$app->user->getId();
        
        if(!empty($data['email'])){
            $profile = UserModel::findOne($userid);
            $profile->email = $data['email'];
            $profile->save();
        }
        
        //first_name
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'first_name'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'first_name', 
                'meta_value'=>$data['first_name'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        //last_name
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'last_name'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'last_name', 
                'meta_value'=>$data['last_name'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        
        //about
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'about'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'about', 
                'meta_value'=>$data['about'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        
        //location
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'location'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'location', 
                'meta_value'=>$data['location'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        

        //website
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'website'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'website', 
                'meta_value'=>$data['website'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        
        //paypal_email
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'paypal_email'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'paypal_email', 
                'meta_value'=>$data['paypal_email'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        
        //latlong
        if (($usermeta = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'latlng'])) === null) {
            $usermeta = new UserMeta();
        }
        $meta_data = [
            'UserMeta'=>[
                'meta_key'=>'latlng', 
                'meta_value'=>$data['latlng'],
                'user_id'=>$userid
            ]
        ];
        $usermeta->load($meta_data);
        $usermeta->save();
        
        if(!empty($data['photo'])){
            if (($user = UserModel::findOne($userid)) !== null) {
                $p = explode('pix/', $data['photo']);
                $user->photo = $p[1];
                $user->save();
            }
        }
        
        return ['status'=>true];

    }
    
    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
