<?php
namespace app\controllers;
use Yii;
use app\models\BoardEntry;
use app\models\CookBoard;
use app\models\CookBoardPin;
use app\models\BoardEntryPhoto;
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
                            'create','update', 'upload'],
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
        $model = new BoardEntry();
        $cookboard = new CookBoard();
        $cookboard->featured = 0;
        return $this->render('index', [
            'model' => $model,'photo'=>new BoardEntryPhoto(), 
            'cookboard'=> $cookboard
        ]);
    }
    
    public function actionDetails($id)
    {
        return $this->render('details', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionUpload(){
        $model = new BoardEntryPhoto();
        if (Yii::$app->request->isPost) {
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
        if(CookBoard::findOne(['id'=>$id,'user_id'=>Yii::$app->user->getId()])!== null) {
            $model = new BoardEntry();
            $model->cook_board_id = $id;
            return $this->render('form', [
                'model' => $model,'photo'=>new BoardEntryPhoto()
            ]);
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel(['id'=>$id,'user_id'=>Yii::$app->user->getId()]);
        if($model->user_id === Yii::$app->user->getId()){
            return $this->render('form', [
                'model' => $model,'photo'=>new BoardEntryPhoto()
            ]);
        }
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
            
            //update photo title,desc
            if(!empty($post['oldpicid'])){
                $x=0;
                foreach($post['oldpicid'] as $photoid){
                    
                    $boardEntryPhoto = BoardEntryPhoto::findOne(['id'=>$photoid]);
                    if($boardEntryPhoto!==null && $boardEntryPhoto->boardEntry->user_id === $userid){
                        $boardEntryPhoto->title = $post['oldpictitle'][$x];
                        $boardEntryPhoto->description = $post['oldpictitle'][$x];
                        $boardEntryPhoto->save();
                    }
                    $x++;
                }
            }
            
            return $this->redirect(['cookboard/details', 'id' => $model->cook_board_id]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
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
    
    protected function findModel($id)
    {
        if (($model = BoardEntry::findOne($id)) !== null) {
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
    
    protected function deletepin()
    {        
        $data = Yii::$app->request->post();
        if(!empty($data['id'])){
            $model = CookBoardPin::findOne(['id'=>$data['id'],'user_id'=>Yii::$app->user->getId()]);
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
}
