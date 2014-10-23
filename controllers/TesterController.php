<?php

namespace app\controllers;

use Yii;
use app\models\Tester;
use app\models\TesterModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TesterController implements the CRUD actions for Tester model.
 */
class TesterController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionUploadsize()
    {
        $max_upload = (int)(ini_get('upload_max_filesize'));
        echo "upload_max_filesize: $max_upload";echo "<br>";
        $post_max_size = (int)(ini_get('post_max_size'));
        echo "post_max_size: $post_max_size";echo "<br>";
        $memory_limit = (int)(ini_get('memory_limit'));
        echo "memory_limit: $memory_limit";echo "<br>";
        //$upload_mb = min($max_upload, $max_post, $memory_limit);
        //echo "upload_mb: $upload_mb";echo "<br>";
    }
    
    public function actionPhpinfo()
    {
        phpinfo();
    }
    
    /**
     * Lists all Tester models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TesterModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tester model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tester model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tester();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tester model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tester model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tester model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tester the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tester::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	public function actionImportphoto(){
	
		
		return $this->render('importphoto');
	
	
	}
	public function actionPinterest(){
	
		 $model = new Tester();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('pinterest', [
                'model' => $model,
            ]);
        }
	
		

	}
	
	public function actionLink(){
	
		$link_user = Yii::$app->request->post('link');
		$link = str_replace('/pins/','/pins',$link_user);
		$api_url = str_replace('pinterest.com','pinterestapi.co.uk',$link);
		$url = $api_url;
		Yii::$app->curlclient->get($url);
		$i = 0;
		
		$result = Yii::$app->curlclient->currentResponse('body');
		
		$res = json_decode($result,true);
		if($res != NULL){
		foreach($res["body"] as $pins){
		
			$photos[$i]=array("url"=>str_replace('192x','736x',$pins["src"]),"title"=>$pins["desc"]);
			
			//$photos['url'][$i] = str_replace('192x','736x',$pins["src"]);
			//$photos['title'][$i] = $pins["desc"];
			$i++;
		}
		$res_photos = $photos;
		}else{
			$res_photos = 0;
		
		}
		
		return $this->render('selectpinterestphotos',['res' => $res_photos]);
	
	}
	
	
	
}
