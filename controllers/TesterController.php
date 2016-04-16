<?php

namespace app\controllers;

use Yii;



use app\models\UserFollow;
use app\models\BoardEntryLike;
use app\models\Orders;

use app\models\Establishments;


use app\models\CookBoard;
use app\models\UserModel;
use app\models\UserMeta;
use app\models\OrdersPayment;
use app\models\Tester;
use app\models\TesterModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
 
/**
 * TesterController implements the CRUD actions for Tester model.
 */
class TesterController extends Controller
//class TesterController extends \app\components\Safecontroller
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
    
    protected function getimage()
    {        
        $data = Yii::$app->request->post();
        
        $subject = file_get_contents($data['url']);
        $images = [];
        preg_match_all('/<img[^>]+src="(.*?)"/i', $subject, $result, PREG_PATTERN_ORDER);
        for ($i = 0; $i < count($result[0]); $i++) {
            //$images[]=$result[0][$i];
            $array = array();
            preg_match( '/src="([^"]*)"/i', $result[0][$i], $array ) ;
            $images[]=$array[1];
        }
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderAjax('//cookboard/_post_entry_modal_thumb',['images'=>$images]);
        
    }
	public function actionNewmembers()
	{
		$profile = $this->findUserModel(Yii::$app->user->getId());
		$newMembers = $profile->getNewmembers();
		
		
		foreach($newMembers as $member){
			//echo $member->id;
			//echo '<br>';
			echo '<pre>';
			print_r($member);
			echo '</pre>';
		}
		
		die();
	} 
	
	public function actionInvite()
	{
		$cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
		$cookboardlist = CookBoard::find()->where(['user_id' => Yii::$app->user->getId()])->all();
		return $this->render('invite',['cookboard'=>$cookboard, 'cookboardlist'=> $cookboardlist]);
	}
	
	public function actionSitemap()
    {
        $users = \app\models\UserModel::find()
                ->orderBy('username')
                ->all();
        
        $cookboards = \app\models\CookBoard::find()
                ->orderBy('name')
                ->all();
        
        $boards = \app\models\BoardEntry::find()
                ->orderBy('name')
                ->all();
        
        return $this->render('//site/sitemap',
                [
                    'users'=>$users,
                    'cookboards'=>$cookboards,
                    'boards'=>$boards
                ]);
    }
	
    public function actionTestpayment()
    {
        $userMeta = UserMeta::findOne(['user_id'=>1,'meta_key'=>'paypal_email']);
        var_dump($userMeta->meta_value);
        die();
        $payment = new OrdersPayment();
                        
        $payment->orders_id = 1;
        $payment->amount = 2;
        $payment->status = 'completed';
        $payment->payer_email = 'a@a.com';
        $payment->receiver_email = 'b@b.com';
        $payment->summary = 'summary';
        $payment->save();
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
    
    public function actionUpdateboard()
    {
        die();
        $board = \app\models\BoardEntry::find()->all();
        foreach($board as $b){
            echo '<br>'.$b->name;
            if(\app\models\CookBoardItems::findOne(['board_entry_id'=>$b->id,'cook_board_id'=>$b->cook_board_id])===null){
                $cookboardItems = new \app\models\CookBoardItems();
                $cookboardItems->user_id = $b->user_id;
                $cookboardItems->cook_board_id = $b->cook_board_id;
                $cookboardItems->board_entry_id = $b->id;
                $cookboardItems->save();
            }
        }
        
        $board = \app\models\CookBoardPin::find()->all();
        foreach($board as $b){
            if(\app\models\CookBoardItems::findOne(['pin_board_entry_id'=>$b->board_entry_id,'cook_board_id'=>$b->cook_board_id])===null){
                $cookboardItems = new \app\models\CookBoardItems();
                $cookboardItems->user_id = $b->user_id;
                $cookboardItems->cook_board_id = $b->cook_board_id;
                $cookboardItems->pin_board_entry_id = $b->board_entry_id;
                $cookboardItems->save();
            }
        }
    }
	
	public function actionPactsafe()
    {
		 $this->layout = 'blank';
        return $this->render('pactsafe');
    }
    
	public function actionPactsafe2()
    {
		 $this->layout = 'blank';
        return $this->render('pactsafe2');
    }
	
    public function actionPhpinfo()
    {
        phpinfo();
    }
    
    public function actionImg()
    {
        $this->layout = 'main';
        return $this->render('img');
    }
    
    public function actionPaypal()
    {
        return $this->render('paypal');
    }

	public function actionDirectpaypal(){
		// Prepare GET data
		$query = array();
		$query['business'] ="kjcastanos@gmail.com";
		$query['notify_url'] = Yii::$app->urlManager->createAbsoluteUrl('ipn/notify');
		$query['return'] = Yii::$app->urlManager->createAbsoluteUrl('ipn/index');
		$query['cancel_return'] = Yii::$app->urlManager->createAbsoluteUrl('checkout/index');
		
		$query['cmd'] = '_cart';
		$query['upload'] = '1';

		//$query['first_name'] = 'nan';
		//$query['last_name'] = 'tester';
		//$query['email'] = 'tester@cookboard.com';
		//$query['address1'] = 'davao city';
		//$query['zip'] = '8000';
		
		$i=1;
		$query['item_name_'.$i] = 'description1';
		$query['quantity_'.$i] = 1;
		$query['amount_'.$i] = 1;
		
		$i++;
		$query['item_name_'.$i] = 'description2';
		$query['quantity_'.$i] = 2;
		$query['amount_'.$i] = 2;
		
		$i++;
		$query['item_name_'.$i] = 'description3';
		$query['quantity_'.$i] = 3;
		$query['amount_'.$i] = 3;

		// Prepare query string
		$query_string = http_build_query($query);
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string;
		return Yii::$app->getResponse()->redirect($url);
	}
	
	public function actionIpn()
    {
		//$this->enableCsrfValidation = false;
        $file = 'people.txt';
        // Open the file to get existing content
        $current = file_get_contents($file);
        // Append a new person to the file
        $current .= "John Smith\n";
        if(!empty($_POST)){
            foreach($_POST as $key => $value){
                $current .= $key.'= '.$value."\n"; //create variable
            }
        }
        $current .= file_get_contents('php://input');
        // Write the contents back to the file
        file_put_contents($file, $current);
        die();
    }

	public function actionIndex2()
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
		
        return $this->render('/profile/index2',[
			'members'=>$members,
            'canFollow'=>false ,
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
            'cookboard'=> Cookboard::findAll([
                'user_id' => $profile->id
            ]),
        ]);

        //return $this->render('index2');
    }
	
    /**
     * Lists all Tester models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        //var_dump(Yii::getAlias('@webroot'));
        //var_dump(Yii::getAlias('@web'));
        //var_dump(Yii::$app->homeUrl);
        //var_dump(\yii\helpers\Url::base());die();
        
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
	
	protected function findUserModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        if (($model = UserModel::findOne($id)) !== null) { 
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function actionInfo(){
		phpinfo();
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
	
	
	
	
	public function actionAndroid(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return json_encode(['test'=>'123']);
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
