<?php
namespace app\controllers;
use Yii;
use app\models\BoardEntry;
use app\models\Cuisine;
use app\models\Diet;
use app\models\UserModel;
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
                        //'roles' => ['@'],
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
        /*if (!Yii::$app->getSession()->has('location')) {
            $url = "http://api.hostip.info/get_json.php?ip=".$_SERVER['REMOTE_ADDR'];
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec ($curl);
            curl_close ($curl);

            Yii::$app->getSession()->set('location', $result);
        }*/
        //$query = BoardEntry::find()->where(['user_id' => Yii::$app->user->getId()]);
        
        $city = '';
        $courseid = '';
        $cuisineid = '';
        $dietid = '';
        $q = '';
        $type = 'entry'; 
        if(Yii::$app->request->post()){
            $type = Yii::$app->request->post('type');
            $name = 'name';
            if($type==='board'){
                $query = CookBoard::find()->innerJoinWith('user');
            }elseif($type==='user'){
                $query = UserModel::find();
            }else{
                $query = BoardEntry::find()->innerJoinWith('cookboard')->innerJoinWith('user');
				$name = 'board_entry.name';
            }
            
            $course_id = Yii::$app->request->post('course');
            $cuisine_id = Yii::$app->request->post('cuisine');
            $diet_id = Yii::$app->request->post('diet');
            $city = Yii::$app->request->post('city');
            $q = Yii::$app->request->post('q');
            
            if(!empty($course_id)){
                //$query->andFilterWhere(['course_id' => $course_id]);
                $arr_course_id = explode(",", $course_id);
                $courseid = '"'.implode('","',$arr_course_id).'"';
                foreach($arr_course_id as $id){
                    if(count($arr_course_id)>1){
                        $query->orFilterWhere(['course_id' => $id]);
                    }else{
                        $query->andFilterWhere(['course_id' => $id]);
                    }
                }
            }
            
            if(!empty($cuisine_id )){
                $arr_cuisine_id = explode(",", $cuisine_id);
                $cuisineid = '"'.implode('","',$arr_cuisine_id).'"';
                foreach($arr_cuisine_id as $id){
                    if(count($arr_cuisine_id)>1){
                        $query->orFilterWhere(['cuisine_id' => $id]);
                    }else{
                        $query->andFilterWhere(['cuisine_id' => $id]);
                    }
                }
            }
            
            if(!empty($diet_id )){
                $arr_diet_id = explode(",", $diet_id);
                $dietid = '"'.implode('","',$arr_diet_id).'"';
                
                foreach($arr_diet_id as $id){
                    if(count($arr_diet_id)>1){
                        $query->orFilterWhere(['diet_id' => $id]);
                    }else{
                        $query->andFilterWhere(['diet_id' => $id]);
                    }
                }
            }
            
            if(!empty($city)){
                if($type==='user'){
                    $query = UserModel::find()->innerJoinWith([
                        'userMeta' => function ($sqlQuery) {
                            $sqlQuery->where('meta_key = "location" ');
                        }
                    ]);
                    //$query->orFilterWhere(['meta_value' => $city]);
                    $query->where(['like', 'meta_value', $city]);
                }else{
                    $query->andFilterWhere(['like','city' ,$city]);
                }
            }
            
            if($type==='user'){
                $query->andFilterWhere(['like', 'slug', $q]);
                //$query->orFilterWhere(['like', 'slug', $q]);
            }else{
				$arr_q = explode(' ',$q);
				if(count($arr_q)>1){
					foreach($arr_q as $q1){
						$query->orFilterWhere(['like', $name, $q1]);
					}
				}else{
					$query->andFilterWhere(['like', $name, $q]);
				}
            }
        }else{
            $query = BoardEntry::find()->innerJoinWith('cookboard')->innerJoinWith('user');
        }
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize'=>20]);
        
        $pages->setPage(Yii::$app->request->post('page'));
       
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        $cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        
        return $this->render('index', [
			'ispost'=>(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'),
            'type'=> $type,
            'loc'=>$city,
            'courseid' => $courseid,
            'cuisineid' => $cuisineid,
            'dietid' => $dietid,
            'q' => $q,
            'models' => $models,
            'diet'=> Diet::find()->all(),
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
        
        if(method_exists(__CLASS__, Yii::$app->z->method($action)) && $action==='query'){           
            return $this->{Yii::$app->z->method($action)}($_POST);
        }else if(method_exists(__CLASS__, Yii::$app->z->method($action)) && !\Yii::$app->user->isGuest){
            return $this->{Yii::$app->z->method($action)}($_POST);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function query()
    {
        $city = '';
        $courseid = '';
        $cuisineid = '';
        $dietid = '';
        $q = '';
        $type = 'entry'; 
        if(Yii::$app->request->post()){
            $type = Yii::$app->request->post('type');
            $name = 'name';
            if($type==='board'){
                $query = CookBoard::find()->innerJoinWith('user');
				$query->andFilterWhere(['>', 'board_count', 0]);
            }elseif($type==='user'){
                $query = UserModel::find();
				$query->andFilterWhere(['<>', 'id', 1]);
            }else{
                $query = BoardEntry::find()->innerJoinWith('cookboard')->innerJoinWith('user');
				$name = 'board_entry.name';
            }
            
            $course_id = Yii::$app->request->post('course');
            $cuisine_id = Yii::$app->request->post('cuisine');
            $diet_id = Yii::$app->request->post('diet');
            $city = Yii::$app->request->post('city');
            $q = Yii::$app->request->post('q');
            
            if(!empty($course_id)){
                //$query->andFilterWhere(['course_id' => $course_id]);
                $arr_course_id = explode(",", $course_id);
                $courseid = '"'.implode('","',$arr_course_id).'"';
                foreach($arr_course_id as $id){
                    if(count($arr_course_id)>1){
                        $query->orFilterWhere(['course_id' => $id]);
                    }else{
                        $query->andFilterWhere(['course_id' => $id]);
                    }
                }
            }
            
            if(!empty($cuisine_id )){
                $arr_cuisine_id = explode(",", $cuisine_id);
                $cuisineid = '"'.implode('","',$arr_cuisine_id).'"';
                foreach($arr_cuisine_id as $id){
                    if(count($arr_cuisine_id)>1){
                        $query->orFilterWhere(['cuisine_id' => $id]);
                    }else{
                        $query->andFilterWhere(['cuisine_id' => $id]);
                    }
                }
            }
            
            if(!empty($diet_id )){
                $arr_diet_id = explode(",", $diet_id);
                $dietid = '"'.implode('","',$arr_diet_id).'"';
                
                foreach($arr_diet_id as $id){
                    if(count($arr_diet_id)>1){
                        $query->orFilterWhere(['diet_id' => $id]);
                    }else{
                        $query->andFilterWhere(['diet_id' => $id]);
                    }
                }
            }
            
            if(!empty($city)){
                if($type==='user'){
                    $query = UserModel::find()->innerJoinWith([
                        'userMeta' => function ($sqlQuery) {
                            $sqlQuery->where('meta_key = "location" ');
                        }
                    ]);
                    //$query->orFilterWhere(['meta_value' => $city]);
                    $query->where(['like', 'meta_value', $city]);
                }else{
                    $query->andFilterWhere(['like','city' ,$city]);
                }
            }
            
            if($type==='user'){
                $query->andFilterWhere(['like', 'slug', $q]);
                //$query->orFilterWhere(['like', 'slug', $q]);
            }else{
                $arr_q = explode(' ',$q);
				if(count($arr_q)>1){
					foreach($arr_q as $q){
						$query->orFilterWhere(['like', $name, $q]);
					}
				}else{
					$query->andFilterWhere(['like', $name, $q]);
				}
            }
        }else{
            $query = BoardEntry::find()->innerJoinWith('cookboard')->innerJoinWith('user');
        }
        
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize'=>20]);
        
        $pages->setPage(Yii::$app->request->post('page'));
       
        $models = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        
        $cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        
        return $this->renderAjax('results', [
            'type'=> $type,
            'loc'=>$city,
            'courseid' => $courseid,
            'cuisineid' => $cuisineid,
            'dietid' => $dietid,
            'q' => $q,
            'models' => $models,
            'diet'=> Diet::find()->all(),
            'cuisine'=> Cuisine::find()->all(),
            'course'=> Course::find()->all(),
            'pages' => $pages,
            'cookboardlist'=> //select from cookboard
                CookBoard::find()->where(['user_id' => $userid = Yii::$app->user->getId()])->all(),
            'cookboard'=>  $cookboard
        ]);
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
            //$model = new CookBoardPin();
            //if ($model->load($post) && $model->save() && $model!==null) {
            
            $model = new \app\models\CookBoardItems();
            $model->pin_board_entry_id = $post['CookBoardPin']['board_entry_id'];
            $model->cook_board_id = $post['CookBoardPin']['cook_board_id'];
            
            if($model->save()){
                return ['status'=>true,'id'=>$post['CookBoardPin']['board_entry_id']];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function wishlist()
    {
        $type = 'entry'; 
        if(Yii::$app->request->post()){
            $type = Yii::$app->request->post('type');
            if($type==='entry'||empty($type)){
                $course_id = Yii::$app->request->post('course');
                $cuisine_id = Yii::$app->request->post('cuisine');
                $diet_id = Yii::$app->request->post('diet');
                $city = Yii::$app->request->post('city');
                $q = Yii::$app->request->post('q');
                
                $model = new \app\models\Wishlist();
                $model->keyword = $q;
                $model->course = $course_id;
                $model->cuisine = $cuisine_id;
                $model->diet = $diet_id;
                $model->city = $city;
                $userid = Yii::$app->user->getId();
                $model->user_id = $userid;
                if($model->save()){
                    return ['status'=>true];
                }
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
