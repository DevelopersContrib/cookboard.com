<?php
namespace app\controllers;
use Yii;
use yii\filters;
use yii\filters\VerbFilter;
use app\models\CookBoard;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends \app\components\Safecontroller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
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
        $cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        return $this->render('index',['cookboardlist'=> //select from cookboard
            CookBoard::find()->where(['user_id' => $userid = Yii::$app->user->getId()])->all(),
        'cookboard'=>  $cookboard]);
    }

}
