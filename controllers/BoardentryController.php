<?php
namespace app\controllers;
use Yii;
use app\models\BoardEntry;
use app\models\CookBoard;
use app\models\CookBoardPin;
use app\models\BoardEntryRating;
use app\models\BoardEntryLike;
use app\models\Establishments;
use app\models\BoardEntryEstablishments;
use app\models\BoardEntryPhoto;
use app\models\BoardEntryPost;
use app\models\UserModel;
use app\models\Review;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class BoardentryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'ajax', 'save', 
                            'create','update', 'upload', 'post', 'savepost','likes'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['details','ajaxp'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'ajax' => ['post'],
					//'ajaxp' => ['post'],
                ],
            ],
        ];
    }
    
    /*public function actionIndex()
    {
        $model = new BoardEntry();
        $cookboard = new CookBoard();
        $cookboard->featured = 0;
        return $this->render('index', [
            'model' => $model,'photo'=>new BoardEntryPhoto(), 
            'cookboard'=> $cookboard
        ]);
    }*/
    
    public function actionLikes($slug)
    {
        $model = $this->findModel(['slug'=>$slug]);

        $items = BoardEntryLike::findAll(['board_entry_id'=>$model->id]);
        
        return $this->render('likes', ['model'=>$model,
            'items' => $items
        ]);
    }
    
    public function actionDetails($slug)
    {
		$gocart = Yii::$app->request->get('gocart');
        $cookboard_slug = Yii::$app->request->get('cookboard');
        $parent_cookboard = false;
        if(!empty($cookboard_slug)){ //check if valid cookboard slug
            $parent_cookboard = $this->findCookboard(['slug'=>$cookboard_slug]);
        }
        
        $userid = Yii::$app->user->getId();
        
        $model = $this->findModel(['slug'=>$slug]);
        
        $cookboard = new CookBoard(); //to generate form
        $cookboard->featured = 0;
        
        $canRate = !Yii::$app->user->isGuest?
            BoardEntryRating::find()->where(['board_entry_id'=>$model->id,'user_id'=>$userid])->count()<1:false;
        
        $order_items = new \app\models\OrdersItem();
        $sales = $order_items->getTotalSale($model->id);
        
        $canLike = BoardEntryLike::findOne(['user_id'=>$userid,'board_entry_id'=>$model->id])===null;
		
		$cookboardcount = CookBoard::find()->where(['user_id' => $model->user_id])->count();		
		$boardentrycount = BoardEntry::find()->where(['user_id' => $model->user_id])->count();
		
		$likescount = BoardEntry::find()
		->innerJoinWith('boardEntryLike')
		->where(['board_entry.user_id' => $model->user_id])
		->count();
		
		$currentuser = "";
		if(!Yii::$app->user->isGuest){
			$currentuser = UserModel::findOne(['id'=>$userid]);
		}
		
        return $this->render('details', [
			'gocart'=>$gocart,
			'currentuser'=>$currentuser,
			'likescount'=>$likescount,
			'cookboardcount'=>$cookboardcount,
			'boardentrycount'=>$boardentrycount,
            'model' => $model,
            'sales'=>$sales,
            'parent_cookboard' =>$parent_cookboard,
            'cookboard'=>  $cookboard,
            'cookboardlist'=> //select from cookboard
                CookBoard::find()->where(['user_id' => $userid = Yii::$app->user->getId()])->all(),
            'userCan'=>[
                'rate'=>$canRate && ($model->user_id != $userid),
				//'rate'=>true,
                'edit'=>(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()),
                'buy'=>!Yii::$app->user->isGuest,
                //'like'=>(!Yii::$app->user->isGuest?$model->user_id!==$userid:false) && $canLike
				'like'=> $canLike
                ],
                
        ]);
    }
    
    public function actionUpload(){
        $model = new BoardEntryPhoto();
        if (Yii::$app->request->isPost) {
            
            $info = getimagesize($_FILES['BoardEntryPhoto']['tmp_name']['photo']);
            
            if ($info === FALSE) {
                throw new NotFoundHttpException('Unable to determine image type of uploaded file');
            }

            if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                throw new NotFoundHttpException('Not a gif/jpeg/png');
            }

            $model->photo = UploadedFile::getInstance($model, 'photo');
            $filename = time() .md5(uniqid(rand(), true)).'.'.$model->photo->extension;
            $model->photo->saveAs('pix/' . $filename);

            $return = [
                'files'=> [[
                    'name' => $model->photo->baseName,
                    'url' => Yii::$app->homeUrl.'pix/'.$filename,
                    'thumbnailUrl' =>Yii::$app->homeUrl.'pix/'.$filename
                ]]
            ];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return json_encode($return);
        }
    }
    
    public function actionCreate($id)
    {
        //check if board belongs to user
		$userid = Yii::$app->user->getId();
        if(CookBoard::findOne(['id'=>$id,'user_id'=>$userid])!== null) {
            $model = new BoardEntry();
            $model->cook_board_id = $id;
            $establishments = Establishments::find()->where(['user_id'=>$userid])->all();
            return $this->render('form', [
                'model' => $model,'photo'=>new BoardEntryPhoto(),
                'establishments'=>$establishments,
                'postimg'=> isset($_REQUEST['postimg'])? $_REQUEST['postimg'] :''
            ]);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPost($id)
    {
        //check if board belongs to user
        $userid = Yii::$app->user->getId();
        if(CookBoard::findOne(['id'=>$id,'user_id'=>$userid])!== null) {
            $model = new BoardEntryPost();
            $model->cook_board_id = $id;
			$establishments = Establishments::find()->where(['user_id'=>$userid])->all();
            return $this->render('post', [
                'model' => $model,'photo'=>new BoardEntryPhoto(),
                'establishments'=>$establishments,
                'postimg'=> isset($_REQUEST['postimg'])? $_REQUEST['postimg'] :''
            ]);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionUpdate($slug)
    {
        $userid = Yii::$app->user->getId();
        $model = $this->findModel(['slug'=>$slug,'user_id'=>$userid]);
        $establishments = Establishments::find()->where(['user_id'=>$userid])->all();
        $m = $this->findModelPost($model->id);
        
        if($model->post_type===BoardEntry::POST_TYPE_STATUS){
            return $this->render('post', [
                'model' => $this->findModelPost($model->id),'photo'=>new BoardEntryPhoto(),'establishments'=>$establishments
            ]);
        }else{
            return $this->render('form', [
                'model' => $model,'photo'=>new BoardEntryPhoto(),'establishments'=>$establishments
            ]);
        }
        //if($model->user_id === Yii::$app->user->getId()){
            
        //}
        throw new NotFoundHttpException('The requested page does not exist.');
    }
        
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        
        $userid = Yii::$app->user->getId();
        $cookboard = new CookBoard();
        
        if ($cookboard->load($post) && $cookboard->save() && $cookboard!==null) {
            $post['BoardEntry']['cook_board_id'] = $cookboard->id;
        }
        
        if(!empty($post['BoardEntry']['id'])){
            $model = $this->findModel(['id'=>$post['BoardEntry']['id'],'user_id'=>$userid]);
            $flash = ucwords($post['BoardEntry']['name']).' has been updated successfully!';
        }else{
            $model = new BoardEntry();
            $flash = ucwords($post['BoardEntry']['name']).' has been created successfully!';
        }
        $post['BoardEntry']['post_type'] = BoardEntryPost::POST_TYPE_FOR_SALE;
        if ($model->load($post) && $model->save() && $model!==null) {
            Yii::$app->session->setFlash('msg', $flash);
            
            //new photo
            if(!empty($post['photo'])){
                $x=0;
                foreach($post['photo'] as $photo){
                    $p = explode('pix/', $photo);
                    if(!empty($p)){
                        $boardEntryPhoto = new BoardEntryPhoto();
                        $boardEntryPhoto->board_entry_id = $model->id;
                        $boardEntryPhoto->photo = 'pix/'.$p[1];
                        
                        $title = isset($post['pictitle'][$x])?$post['pictitle'][$x]:"";
                        $desc = isset($post['picdesc'][$x])?$post['picdesc'][$x]:"";
                        
                        $x++;
                        $boardEntryPhoto->seq = $x;
                        
                        $boardEntryPhoto->title = $title;
                        $boardEntryPhoto->description = $desc;
                        $boardEntryPhoto->save();
                    }
                }
            }
            
            //new photo url
            if(!empty($post['photo_url'])){
                $x=0;
                foreach($post['photo_url'] as $photo_url){
                    if(!empty($photo_url)){
                        if (filter_var($photo_url, FILTER_VALIDATE_URL) !== false){
                            $boardEntryPhoto = new BoardEntryPhoto();
                            $boardEntryPhoto->board_entry_id = $model->id;
                            $boardEntryPhoto->photo = $photo_url;

                            $title = isset($post['photo_url_title'][$x])?$post['photo_url_title'][$x]:"";
                            $desc = isset($post['photo_url_desc'][$x])?$post['photo_url_desc'][$x]:"";

                            $x++;
                            $boardEntryPhoto->seq = $x;

                            $boardEntryPhoto->title = $title;
                            $boardEntryPhoto->description = $desc;
                            $boardEntryPhoto->external = 1;
                            $boardEntryPhoto->save();
                        }
                    }
                }
            }
            
            //update photo title,desc
            if(!empty($post['oldpicid'])){
                $x=0;
                foreach($post['oldpicid'] as $photoid){
                    $boardEntryPhoto = BoardEntryPhoto::findOne(['id'=>$photoid]);
                    if($boardEntryPhoto!==null && $boardEntryPhoto->boardEntry->user_id === $userid){
                        $boardEntryPhoto->title = $post['oldpictitle'][$x];
                        $boardEntryPhoto->description = $post['oldpicdesc'][$x];
                        $featuredPhoto = $post['featuredphoto'];
						if($photoid==$featuredPhoto){
							$boardEntryPhoto->featured = 1;
						}else{
							$boardEntryPhoto->featured = 0;
						}
						
						$boardEntryPhoto->save();
                    }
                    $x++;
                }
            }
            $establishments_ids = $post['establishments_ids'];
            BoardEntryEstablishments::deleteAll('board_entry_id = '.$model->id);
            if(!empty($establishments_ids)){
                $ids = explode(',',$establishments_ids);
                
                foreach($ids as $establishments_id){
                    $boardEntryEstablishments = new BoardEntryEstablishments();
                    $boardEntryEstablishments->board_entry_id = $model->id;
                    $boardEntryEstablishments->establishments_id = $establishments_id;
                    $boardEntryEstablishments->save();
                }
            }
            
            return $this->redirect(['cookboard/details', 'slug' => $model->cookboard->slug]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionSavepost()
    {
        $post = Yii::$app->request->post();
        
        $userid = Yii::$app->user->getId();
        
        if(!empty($post['BoardEntryPost']['id'])){
            $model = $this->findModelPost(['id'=>$post['BoardEntryPost']['id'],'user_id'=>$userid]);
            $flash = ucwords($post['BoardEntryPost']['name']).' has been updated successfully!';
        }else{
            $model = new BoardEntryPost();
            $flash = ucwords($post['BoardEntryPost']['name']).' has been created successfully!';
        }
        $post['BoardEntryPost']['post_type'] = BoardEntryPost::POST_TYPE_STATUS;
        if ($model->load($post) && $model->save() && $model!==null) {
            Yii::$app->session->setFlash('msg', $flash);
            
            //new photo
            if(!empty($post['photo'])){
                $x=0;
                foreach($post['photo'] as $photo){
                    $p = explode('pix/', $photo);
                    if(!empty($p)){
                        $boardEntryPhoto = new BoardEntryPhoto();
                        $boardEntryPhoto->board_entry_id = $model->id;
                        $boardEntryPhoto->photo = 'pix/'.$p[1];
                        
                        $title = isset($post['pictitle'][$x])?$post['pictitle'][$x]:"";
                        $desc = isset($post['picdesc'][$x])?$post['picdesc'][$x]:"";
                        
                        $x++;
                        //$boardEntryPhoto->seq = $x;
						$boardEntryPhoto->seq = 0;
                        
                        $boardEntryPhoto->title = $title;
                        $boardEntryPhoto->description = $desc;
                        $boardEntryPhoto->save();
                    }
                }
            }
            
            //new photo url
            if(!empty($post['photo_url'])){
                $x=0;
                foreach($post['photo_url'] as $photo_url){
                    if(!empty($photo_url)){
                        if (filter_var($photo_url, FILTER_VALIDATE_URL) !== false){
                            $boardEntryPhoto = new BoardEntryPhoto();
                            $boardEntryPhoto->board_entry_id = $model->id;
                            $boardEntryPhoto->photo = $photo_url;

                            $title = isset($post['photo_url_title'][$x])?$post['photo_url_title'][$x]:"";
                            $desc = isset($post['photo_url_desc'][$x])?$post['photo_url_desc'][$x]:"";

                            $x++;
                            //$boardEntryPhoto->seq = $x;
							$boardEntryPhoto->seq = 0;

                            $boardEntryPhoto->title = $title;
                            $boardEntryPhoto->description = $desc;
                            $boardEntryPhoto->external = 1;
                            $boardEntryPhoto->save();
                        }
                    }
                }
            }
            
            //update photo title,desc
            if(!empty($post['oldpicid'])){
                $x=0;
                foreach($post['oldpicid'] as $photoid){
                    
                    $boardEntryPhoto = BoardEntryPhoto::findOne(['id'=>$photoid]);
                    if($boardEntryPhoto!==null && $boardEntryPhoto->boardEntry->user_id === $userid){
                        $boardEntryPhoto->title = $post['oldpictitle'][$x];
                        $boardEntryPhoto->description = $post['oldpicdesc'][$x];
						//$boardEntryPhoto->seq = 0;
                        $boardEntryPhoto->save();
                    }
                    $x++;
                }
            }
            
            $establishments_ids = $post['establishments_ids'];
            BoardEntryEstablishments::deleteAll('board_entry_id = '.$model->id);
            if(!empty($establishments_ids)){
                $ids = explode(',',$establishments_ids);
                
                foreach($ids as $establishments_id){
                    $boardEntryEstablishments = new BoardEntryEstablishments();
                    $boardEntryEstablishments->board_entry_id = $model->id;
                    $boardEntryEstablishments->establishments_id = $establishments_id;
                    $boardEntryEstablishments->save();
                }
            }
            
            return $this->redirect(['cookboard/details', 'slug' => $model->cookboard->slug]);
        }

        throw new NotFoundHttpException('The requested page does not exist.'.json_encode($model->errors));
    }
    
    /*public function actionSave()
    {
        $post = Yii::$app->request->post();
        
        $userid = Yii::$app->user->getId();
        $cookboard = new CookBoard();
        if ($cookboard->load($post) && $cookboard->save() && $cookboard!==null) {
            $flash = ucwords($post['CookBoard']['name']).' has been created successfully!';
            $model = new BoardEntry();
            $post['BoardEntry']['user_id'] = $userid;


            if ($model->load($post) && $model->save() && $model!==null) {
                Yii::$app->session->setFlash('msg', $flash);

                if(!empty($post['photo'])){
                    $x=0;
                    foreach($post['photo'] as $photo){
                        $p = explode('pix/', $photo);
                        if(!empty($p)){
                            $boardEntryPhoto = new BoardEntryPhoto();
                            $boardEntryPhoto->board_entry_id = $model->id;
                            $boardEntryPhoto->photo = 'pix/'.$p[1];
                            $x++;
                            $boardEntryPhoto->seq = $x;
                            $title = 'Photo';
                            $boardEntryPhoto->title = $title;
                            $boardEntryPhoto->description = $title;
                            $boardEntryPhoto->save();
                        }
                    }
                }
            }
            return $this->redirect(['cookboard/details', 'id' => $cookboard->id]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }*/
    
    protected function findCookboard($id)
    {
        if (($model = CookBoard::findOne($id)) !== null) {
            return $model;
        } else {
            
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModel($id)
    {
        if (($model = BoardEntry::findOne($id)) !== null) {
            return $model;
        } else {
            
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelPost($id)
    {
        if (($model = BoardEntryPost::findOne($id)) !== null) {
            return $model;
        } else {
            
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
	
	public function actionAjaxp()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $action = Yii::$app->request->post('action');

        //if(method_exists(__CLASS__, Yii::$app->z->method($action)))
		if($action==='related')
            return $this->{Yii::$app->z->method($action)}($_POST);
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function rating()
    {
        $data = Yii::$app->request->post();
        if(!empty($data['idBox']) && is_numeric($data['rate'])){
            $userid = Yii::$app->user->getId();
            
            $rating = new BoardEntryRating();
            $rating->board_entry_id = $data['idBox'];
            $rating->rating = $data['rate'];
            $rating->user_id = $userid;
            $status = $rating->save();
            
            return ['status'=>$status];
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
    
	protected function related()
    {
		$param_slug = Yii::$app->request->post('slug');
        $model = $this->findModel(['slug'=>$param_slug]);
		$items = $model->cookboard->items;
        $arr = [];
		foreach($items as $item){
			$slug = '';
			$obj = [];
			$img = '';
			
			if(!empty($item->board_entry_id)){
				$obj = $item->boardEntry;
			}else{
				$obj = $item->pinBoardEntry;
			}
			
			$slug = $obj->slug;
			if($param_slug!==$slug){
				if(!empty($obj->boardEntryPhoto)){
					foreach($obj->boardEntryPhoto as $photo){
						$img = $photo->external===1?$photo->photo:Yii::$app->homeUrl.$photo->photo;
					}
					
					$url = Yii::$app->urlManager->createUrl(['boardentry/details', 'slug' => $slug]);
					
					$arr[] = [
						'url'=>$url,
						'img'=>$img
					];
				}
			}
		}
		
        
        return ['items'=>$arr];
    }
	
    protected function like()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $userid = Yii::$app->user->getId();
            if(BoardEntryLike::findOne(['user_id'=>$userid,'board_entry_id'=>$data['id']])===null){
                $like = new BoardEntryLike();
                $like->board_entry_id = $data['id'];
                $like->user_id = $userid;
                $status = $like->save();
                $count = count(BoardEntryLike::findAll(['board_entry_id'=>$data['id']]));
                return ['status'=>$status,'likes'=>$count];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function review()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $userid = Yii::$app->user->getId();
            
			$review = new Review();
			$review->board_entry_id = $data['id'];
			$review->user_id = $userid;
			$review->message = $data['message']; 
			$status = $review->save();
		
			return ['status'=>$status,'html'=>
				$this->renderAjax('_review_item',['currentuser'=>UserModel::findOne(['id'=>$userid]),'reviews'=>[Review::findOne(['id'=>$review->id])]])];
            
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function removereview()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $review = Review::findOne(['id'=>$data['id']]);
            $userid = Yii::$app->user->getId();
            if($review->user_id == $userid){ //check if data belongs to user
                $status = $review->delete();
                return ['status'=>$status];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function savepin()
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
    
    protected function deletepin()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            //$model = CookBoardPin::findOne(['id'=>$data['id'],'user_id'=>Yii::$app->user->getId()]);
            $model = \app\models\CookBoardItems::findOne(['id'=>$data['id'],'user_id'=>Yii::$app->user->getId()]);
            $status = $model->delete();
            return ['status'=>$status];
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function removepic()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $model = BoardEntryPhoto::findOne($data['id']);            
            $userid = Yii::$app->user->getId();
            if($model->boardEntry->user_id == $userid){ //check if data belongs to user
                $status = $model->delete();
                return ['status'=>$status];
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function getimage()
    {        
        $data = Yii::$app->request->post();
        if (filter_var($data['url'], FILTER_VALIDATE_URL) !== false){
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
		}else{
			return "The URL(<i>".$data['url']."</i>) is invalid and cannot be loaded";
		}
    }
	
	protected function savepost()
    {        
        $post = Yii::$app->request->post();
		
		if($post['CookBoard']['cook_board_id']==='-1'){
            $cookboard = new CookBoard();
            if ($cookboard->load($post) && $cookboard->save() && $cookboard!==null) {
                $post['CookBoard']['cook_board_id'] = $cookboard->id;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
		
		if(!empty($post['photo']) || !empty($post['photo_url'])){
			$x=0;
			if(!empty($post['photo'])){
				foreach($post['photo'] as $photo){
					$title = isset($post['pictitle'][$x])?$post['pictitle'][$x]:"";
					$desc = isset($post['picdesc'][$x])?$post['picdesc'][$x]:"";
					$title = empty($title)?'untitled':$title;
					$post['BoardEntryPost']['name'] = $title;
					$post['BoardEntryPost']['description'] = $desc;
					break;
				}
			}elseif(!empty($post['photo_url'])){
				foreach($post['photo_url'] as $photo_url){
					
					if(!empty($photo_url)){
						//if (filter_var($photo_url, FILTER_VALIDATE_URL) !== false){
							
							$title = isset($post['photo_url_title'][$x])?$post['photo_url_title'][$x]:"";
							$desc = isset($post['photo_url_desc'][$x])?$post['photo_url_desc'][$x]:"";
							$title = empty($title)?'untitled':$title;
							
							$post['BoardEntryPost']['name'] = $title;
							$post['BoardEntryPost']['description'] = $desc;
							break;
						//}
					}
				}
			}
			
			$model = new BoardEntryPost();
			$flash = ucwords($post['BoardEntryPost']['name']).' has been created successfully!';
				
			$post['BoardEntryPost']['post_type'] = BoardEntryPost::POST_TYPE_STATUS;
			$post['BoardEntryPost']['cook_board_id'] = $post['CookBoard']['cook_board_id'];
			
			if ($model->load($post) && $model->save() && $model!==null) {
				Yii::$app->session->setFlash('msg', $flash);
				
					$x=0;
					if(!empty($post['photo'])){
						foreach($post['photo'] as $photo){
							$p = explode('pix/', $photo);
							if(!empty($p)){
								$boardEntryPhoto = new BoardEntryPhoto();
								$boardEntryPhoto->board_entry_id = $model->id;
								$boardEntryPhoto->photo = 'pix/'.$p[1];
								
								$title = isset($post['pictitle'][$x])?$post['pictitle'][$x]:"";
								$desc = isset($post['picdesc'][$x])?$post['picdesc'][$x]:"";
								
								$x++;
								$boardEntryPhoto->seq = $x;
								
								$boardEntryPhoto->title = $title;
								$boardEntryPhoto->description = $desc;
								$boardEntryPhoto->save();
							}
						}
					}elseif(!empty($post['photo_url'])){
						//new photo url
						if(!empty($post['photo_url'])){
							$x=0;
							foreach($post['photo_url'] as $photo_url){
								if(!empty($photo_url)){
									//if (filter_var($photo_url, FILTER_VALIDATE_URL) !== false){
										$boardEntryPhoto = new BoardEntryPhoto();
										$boardEntryPhoto->board_entry_id = $model->id;
										$boardEntryPhoto->photo = $photo_url;

										$title = isset($post['photo_url_title'][$x])?$post['photo_url_title'][$x]:"";
										$desc = isset($post['photo_url_desc'][$x])?$post['photo_url_desc'][$x]:"";

										$x++;
										$boardEntryPhoto->seq = $x;

										$boardEntryPhoto->title = $title;
										$boardEntryPhoto->description = $desc;
										$boardEntryPhoto->external = 1;
										$boardEntryPhoto->save();
									//}
								}
							}
						}
					}
					
				return ['status'=>true,
					'url'=>Yii::$app->urlManager->createAbsoluteUrl(['boardentry/details','cookboard'=> $model->cookboard->slug,  'slug' => $model->slug])];
			}
		}
         
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
