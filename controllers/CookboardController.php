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
    
    public function actionDetails($slug)
    {
        //$model = $this->findModel($id);
		$cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        $model = $this->findModel(['slug'=>$slug]);

        return $this->render('details', [
			'cookboard'=>$cookboard,
			'cookboardlist'=> //select from cookboard
                CookBoard::find()->where(['user_id' => $model->user_id ])->all(),
            'model' => $model,
            'pins'=> CookBoardPin::findAll([
                'user_id' => $model->user_id,
                'cook_board_id'=>$model->id
            ])
        ]);
    }
	
	public function actionMap($slug)
    {
        $model = $this->findModel(['slug'=>$slug]);
        return $this->render('popup_map', [
            'model' => $model
        ]);
    }
    
    public function actionDelete()
    {
        Yii::$app->session->setFlash('msg', 'Deleted successfully!');
        return $this->redirect(['index']);
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
        
        if(Yii::$app->user->identity->type!=\app\models\UserModel::PREMIUM){
            $post['CookBoard']['featured'] = CookBoard::NOT_FEATURED;
        }
                
        if ($model->load($post) && $model->save() && $model!==null) {
            if($update){
                if(!empty($post['type']) && $post['type'] === 'json'){
                    Yii::$app->session->setFlash('msg', $model->name.' has been updated successfully!');
                    return Cookboard::find()->where(['id' => $model->id])->asArray()->one();
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
                    return $this->renderPartial('_board',['item'=>$this->findModel($model->id)]);
                }
            }else{
                return ['status'=>true,'id'=>$model->id,'slug'=>$model->slug];
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
