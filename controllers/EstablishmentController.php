<?php

namespace app\controllers;

use Yii;
use app\models\Establishments;
use app\models\EstablishmentsType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

class EstablishmentController extends Controller
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
    
    public function actionIndex($slug)
    {
        $userid = Yii::$app->user->getId();
        $model = $this->findModel(['slug'=>$slug]);
        return $this->render('index', ['model'=>$model]);
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
        if(!empty($post['Establishments']['id'])){
            $update = true;
            $model = $this->findModel(['id'=>$post['Establishments']['id'],'user_id'=>$userid]);
        }else{
            $model = new Establishments();
        }
        
        $photo = $post['Establishments']['photo'];
        $p = explode('pix/', $photo);
        $post['Establishments']['photo'] = 'pix/'.$p[1];
        
        if ($model->load($post) && $model->save() && $model!==null) {

            $tr = "<tr id='$model->id'>".
                "<td data-id='tr-$model->id'><a target='_blank' href='".Yii::$app->urlManager->createUrl(['establishment/index', 'slug' => $model->slug])."'>$model->name</a></td>".
                "<td >".$model->establishmentsType->name."</td>".
                "<td>$model->location</td>".
                "<td>$model->rating</td>".
                "<td><a data-id='$model->id' class='edit-establishment' href='javascript:;'>Edit</a> | <a data-id='$model->id' class='delete-establishment' href='javascript:;'>Delete</a></td>".
            "</tr>";
            return ['status'=>true,'id'=>$model->id,'tr'=>$tr];
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function delete()
    {
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $userid = Yii::$app->user->getId();
            $model = $this->findModel(['id'=>$data['id'],'user_id'=>$userid]);
            
            $status = $model->delete();
            return ['status'=>$status];
            
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function view()
    {
        $data = Yii::$app->request->post();
        
        if(!empty($data['id'])){
            $establishments = $this->findModel($data['id']);
            if($establishments->user_id===Yii::$app->user->getId()){
                return $establishments;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findModel($id)
    {
        if (($model = Establishments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
