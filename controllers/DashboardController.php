<?php
namespace app\controllers;

use Yii;
use app\models\UserModel;
use app\models\UserMeta;
use app\models\UserFollow;
use app\models\BoardEntryLike;
use app\models\Orders;
use app\models\CookBoard;
use app\models\Establishments;
use app\models\OrdersPayment;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
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
                        'actions' => ['ajax','index'],
                        'roles' => ['@'],
                    ]
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
        $profile = $this->findModel(Yii::$app->user->getId());
        
        $orders = Orders::find()->where(['orders_to'=>$userid])->all();
        $purchases = Orders::find()->where(['user_id'=>$userid])->all();
        
        $establishments = Establishments::find()->where(['user_id'=>$userid])->all();
        
        $orders_payment = OrdersPayment::find()->where(['payment_to'=>$userid])->all();
        $my_payments = OrdersPayment::find()->where(['payment_from'=>$userid])->all();
        
        $likes = count(BoardEntryLike::findAll(['user_id'=>$userid]));
        
        $following = count(UserFollow::findAll(['user_id'=>$userid])); //following
        $followers = count(UserFollow::findAll(['following'=>$userid])); //followers
        
		$newMembers = $profile->getNewmembers();
		$members = [];
		foreach($newMembers as $member){
			$members[] = UserModel::findOne($member->id);
		}
		
		$cookboard2 = \app\models\CookBoard::find()
            ->where('board_count > :c AND user_id = :u ', [':c' => 0,':u'=>$userid])->orderBy('id desc')->all();
			
        return $this->render('/profile/index',[
			'members'=>$members,
            'canFollow'=>false ,
			'follower'=>false,
            'following'=>$following,
            'followers'=>$followers,
			'item_followers'=>UserFollow::findAll(['following'=>$userid]),
            'likes'=>$likes,
            'isOwner'=>$profile->id === $userid,
            'orders'=>$orders,
            'establishments'=>$establishments,
            'establishments_model'=>  new Establishments(),
            'my_payments'=>$my_payments,
            'purchases'=>$purchases,
            'orders_payment'=>$orders_payment,
            'tab'=>$tab,
            'title'=>'Dashboard',
            'profile' => $profile,
			'cookboard2'=>$cookboard2,
            'cookboard'=> Cookboard::findAll([
                'user_id' => $profile->id
            ]),
        ]);
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
    
    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
