<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\OrdersPayment;
use app\models\OrdersModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    public $layout = 'main';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'only' => ['index', 'ajax'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','ajax'],
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
    
    protected function details()
    {
        $data = Yii::$app->request->post();
        $order = $this->findModel($data['id']);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderAjax('details',['order'=>$order]);        
    }
    
    protected function purchase()
    {
        $data = Yii::$app->request->post();
        $order = $this->findModel($data['id']);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderAjax('purchase',['order'=>$order]);        
    }
    
    protected function orderspayment()
    {
        $data = Yii::$app->request->post();
        $payment = $this->findPayment($data['id']);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderAjax('payment',['payment'=>$payment]);        
    }
    
    protected function paypod()
    {
        $data = Yii::$app->request->post();
        $userid = Yii::$app->user->getId();
        $model = $this->findModel($data['orders_add_payment_id']);
        $update = $model->status !==Orders::STATUS_CANCELLED;
        $post['Orders']['payment_status'] = Orders::PAID;
        
        if ($model->load($post) && $model->save() && 
                $model->orders_to === $userid && $update) {
            $order = Orders::findOne($model->id);
            $u = $order->user;
            $tr = '<tr id="tr-'.$order->id.'">
                <td data-id="tr-'.$order->id.'">'.$order->id.'</td>
                <td>'.$order->datetime_created.'</td>
                <td><a href="'.Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]).'">'.$u->username.'</a></td>
                <td>'.$order->getPaymentStatusText().'</td>
                <td>'.$order->getStatusText().'</td>
                <td><a data-id="'.$order->id.'" class="view-orders" href="javascript:;">View Order</a></td>
            </tr>';
            
            if(OrdersPayment::findOne([
                'orders_id' =>$order->id,
                'payment_type'=>OrdersPayment::POD
            ])===null){
                
                $payment = new OrdersPayment();

                $payment->orders_id = $order->id;
                $payment->amount = $order->totals;
                $payment->status = 'Completed';
                $payment->payer_email = '';//current user email
                $payment->receiver_email = '';//$order->user->email;
                $payment->summary = 'POD Payment';

                $payment->payment_type = OrdersPayment::POD;
 
                $payment->payment_from = $order->user_id;
                $payment->payment_to = $userid;
                $payment->txn_id = '';
                
                $payment->save();
            }
           
            return ['status'=>true,'id'=>$order->id,'tr'=>$tr];
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function savepurchase()
    {
        $post = Yii::$app->request->post();
        $userid = Yii::$app->user->getId();
        $model = $this->findModel($post['Orders']['id']);
        $status = $model->status;

        if ($model->load($post) && $model->save() && 
                $model->user_id === $userid && //update if belongs to current user
                $status===Orders::STATUS_PENDING) { // update pending order only
            $order = Orders::findOne($model->id);
            $u = $order->seller;
            $tr = '<tr id="tr-'.$order->id.'">
                <td data-id="tr-'.$order->id.'">'.$order->id.'</td>
                <td>'.$order->datetime_created.'</td>
                <td><a href="'.Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]).'">'.$u->username.'</a></td>
                <td>'.$order->getPaymentStatusText().'</td>
                <td>'.$order->getStatusText().'</td>
                <td><a data-id="'.$order->id.'" class="view-purchases" href="javascript:;">View</a></td>
            </tr>';
            
            return ['status'=>true,'id'=>$order->id,'tr'=>$tr];
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
    protected function save()
    {
        $post = Yii::$app->request->post();
        $userid = Yii::$app->user->getId();
        $model = $this->findModel($post['Orders']['id']);
        $update = $model->status !==Orders::STATUS_CANCELLED;
        if ($model->load($post) && $model->save() && 
                $model->orders_to === $userid && $update) {
            $order = Orders::findOne($model->id);
            
            $payment_status = '';
            $status = '';
            $u = $order->user;
            if($order->status===\app\models\Orders::STATUS_DELIVERED){
                $status = 'Delivered';
            }elseif($order->status===\app\models\Orders::STATUS_CANCELLED){
                $status = 'Cancelled';
            }else{
                $status = 'Pending';
            }
            
            if($order->payment_status===\app\models\Orders::UNPAID){
                $payment_status = 'Unpaid';
            }elseif($order->payment_status===\app\models\Orders::PAID){
                $payment_status = 'Paid';
            }
            
            $tr = '<tr id="tr-'.$order->id.'">
                <td data-id="tr-'.$order->id.'">'.$order->id.'</td>
                <td>'.$order->datetime_created.'</td>
                <td><a href="'.Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $u->slug]).'">'.$u->username.'</a></td>
                <td>'.$payment_status.'</td>
                <td>'.$status.'</td>
                <td><a data-id="'.$order->id.'" class="view-orders" href="javascript:;">View Order</a></td>
            </tr>';
            
            return ['status'=>true,'id'=>$order->id,'tr'=>$tr];
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findPayment($id)
    {
        if (($model = OrdersPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
