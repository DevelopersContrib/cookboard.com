<?php
namespace app\controllers;
use Yii;
use app\models\BoardEntry;
use app\models\Cuisine;
use app\models\CookBoardPin;
use app\models\Course;
use app\models\CookBoard;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class SearchController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['ajax'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
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
        //$query = BoardEntry::find()->where(['user_id' => Yii::$app->user->getId()]);
        $query = BoardEntry::find();
        if(Yii::$app->request->post()){
            $course_id = Yii::$app->request->post('course');
            $cuisine_id = Yii::$app->request->post('cuisine');
            if(!empty($course_id)){
                $query->andFilterWhere(['course_id' => Yii::$app->request->post('course')]);
            }else if(!empty($cuisine_id )){
                $query->andFilterWhere(['cuisine_id' => Yii::$app->request->post('cuisine')]);
            }else{
                $query->andFilterWhere(['like', 'name', Yii::$app->request->post('q')]);
            }
        }
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        $cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        return $this->render('index', [
            'models' => $models,
            'cuisine'=> Cuisine::find()->all(),
            'course'=> Course::find()->all(),
            'pages' => $pages,
            'cookboardlist'=> //select from cookboard
                CookBoard::find()->where(['user_id' => $userid = Yii::$app->user->getId()])->all(),
            'cookboard'=>  $cookboard
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
                
        if($post['CookBoardPin']['cook_board_id']==='-1'){
            $cookboard = new CookBoard();
            if ($cookboard->load($post) && $cookboard->save() && $cookboard!==null) {
                $post['CookBoardPin']['cook_board_id'] = $cookboard->id;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        
        $userid = Yii::$app->user->getId();

        if(BoardEntry::findOne(['id'=>$post['CookBoardPin']['board_entry_id'],'user_id'=>$userid])===null){
            $model = new CookBoardPin();
            if ($model->load($post) && $model->save() && $model!==null) {
                return ['status'=>true,'id'=>$post['CookBoardPin']['board_entry_id']];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
