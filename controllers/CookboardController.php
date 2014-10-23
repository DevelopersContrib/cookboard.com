<?php
namespace app\controllers;

use Yii;
use app\models\CookBoard;
use app\models\CookBoardPin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

class CookboardController extends Controller
{
    public $layout = 'main';
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'only' => ['index', 'ajax', 'details'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'ajax'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['details'],
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
        $cookboard = new CookBoard();
        $cookboard->featured = 0;
        return $this->render('index',
            [
                'cookboard'=>$cookboard,
                'model'=> Cookboard::findAll([
                    'user_id' => Yii::$app->user->getId()
                ]),
            ]);
    }
    
    public function actionDetails($id)
    {
        $model = $this->findModel($id);
        return $this->render('details', [
            'model' => $this->findModel($id),
            'pins'=> CookBoardPin::findAll([
                'user_id' => $model->user_id,
                'cook_board_id'=>$id
            ])
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
    
    protected function save()
    {
        $post = Yii::$app->request->post();
        
        $userid = Yii::$app->user->getId();
        $update = false;
        if(!empty($post['CookBoard']['id'])){
            $update = true;
            $model = $this->findModel(['id'=>$post['CookBoard']['id'],'user_id'=>$userid]);
        }else{
            $model = new CookBoard();
            //$post['CookBoard']['user_id'] = $userid;
        }
        
        if ($model->load($post) && $model->save() && $model!==null) {
            if($update){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
                return $this->renderPartial('_board',['item'=>$this->findModel($model->id)]);
            }else{
                return ['status'=>true,'id'=>$model->id];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function delete()
    {
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $model = $this->findModel($data['id']);
            $userid = Yii::$app->user->getId();
            if($model->user_id == $userid){ //check if data belongs to user
                $status = $model->delete();
                return ['status'=>$status];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function view()
    {
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $cookboard = $this->findModel($data['id']);
            if($cookboard->user_id===Yii::$app->user->getId()){
                return $cookboard;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel($id)
    {
        if (($model = Cookboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
