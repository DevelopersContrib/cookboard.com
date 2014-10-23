<?php
namespace app\controllers;

use Yii;
use app\models\UserModel;
use app\models\UserMeta;
use app\models\CookBoard;
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
                        'actions' => ['ajax'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        
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
        $slug = Yii::$app->request->queryParams['slug'];
        $profile = $this->findModel(['slug'=>$slug]);
        return $this->render('index',[
            'profile' => $profile,
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
    
    protected function details()
    {
        $data = Yii::$app->request->post();
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
