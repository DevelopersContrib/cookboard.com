<?php

namespace app\controllers;
use Yii;
use app\models\BoardEntry;
use app\models\UserMeta;
use app\models\CustomerForm;
use app\models\Orders;
use app\models\OrdersItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters;
use yii\filters\VerbFilter;

class CheckoutController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'ajax', 
                            'cart', 'clear', 'info', 'submit', 'pod'],
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
        $post = Yii::$app->request->post();
        
        if (!Yii::$app->getSession()->has('cart')) {
            Yii::$app->getSession()->set('cart', []);
        }
        $cart = Yii::$app->getSession()->get('cart');
        
        $items = [];
        $referrer = '';
        if(!empty($post)){
            $referrer = !empty($post['referrer'])?$post['referrer']:'';
            
            if(!empty($post['BoardEntry'])){
                $id = $post['BoardEntry']['id'];
                $model = $this->findModel($post['BoardEntry']['id']);
                $cart[$id]=[
                    'board_entry_id'=>$post['BoardEntry']['id'],
                    'user_id'=>$model->user_id,
                    'qty'=>1
                ];
                $cart = array_unique($cart, SORT_REGULAR);
                Yii::$app->getSession()->set('cart', $cart);
            }
        }
        
        $items = Yii::$app->getSession()->get('cart');
        
        usort($items, function($a, $b) {
            return $a['user_id'] - $b['user_id'];
        });
        
        $cart = [];
        foreach($items as $c){
            $cart[$c['board_entry_id']] = $c;
        }
        
        if(count($cart)<1){
            return $this->redirect('dashboard/purchases',302);
            //$url = Yii::$app->urlManager->createAbsoluteUrl('orders/index');
            //return Yii::$app->getResponse()->redirect($url);
        }else{
            $items = [];
            $perUser = [];
            foreach($cart as $item){
                $model = $this->findModel($item['board_entry_id']);
                $perUser[$model->user_id][] = $model;
                $items[] = $model;
            }
            return $this->render('index',['perUser'=>$perUser, 'items'=>$items,'cart'=>$cart,'referrer'=>$referrer]);
        }
    }
    
    public function actionClear()
    {
        unset(Yii::$app->session['cart']);
        return $this->goHome();
    }
    
    public function actionPod()
    {
        $post = Yii::$app->request->post();
        if (Yii::$app->getSession()->has('cart') && !empty($post) && !empty($post['i'])) {
            $cart = Yii::$app->getSession()->get('cart');
            $totals = 0;
            $payment_to = 0;
            
            $order = new Orders();
            $order->user_id = Yii::$app->user->getId();
            $order->totals = 0;
            $order->status = Orders::STATUS_PENDING;
            $order->payment_status = Orders::UNPAID;
            $order->notes = $post['notes'];
            $order->save();

            $i = 1;
            $x = 0;
            foreach($post['entry'] as $item){
                if(($boardEntry = BoardEntry::findOne($item))!==null ){
                    $orderItem = new OrdersItem();
                    
                    $payment_to = $boardEntry->user_id;
                    
                    $qty = !empty($post['qty'][$x])?$post['qty'][$x]:1;

                    $orderItem->orders_id = $order->id;
                    $orderItem->board_entry_id = $boardEntry->id;
                    $orderItem->qty = $qty;
                    $orderItem->price = $boardEntry->price;
                    $total = ($qty * $boardEntry->price);
                    $orderItem->total = $total;

                    $totals = $totals + $total;

                    if($orderItem->save()){
                        $paypal_items['item_name_'.$i] = $boardEntry->name;
                        $paypal_items['quantity_'.$i] = $qty;
                        $paypal_items['amount_'.$i] = $boardEntry->price;
                        $i++;
                    }
                    
                    unset($cart[$item]); //remove from cache checkout
                    Yii::$app->getSession()->set('cart', $cart); // 
                    
                }
                $x++;
            }

            $order->totals = $totals;
            $order->orders_to = $payment_to;
            $order->save();
            
            Yii::$app->session->setFlash('msg', 'Orders has been save successfully!');
            $url = Yii::$app->urlManager->createAbsoluteUrl('checkout/index');
            return Yii::$app->getResponse()->redirect($url);
            
            //return $this->render('index');
        }
    }
    
    public function actionSubmit()
    {
        $post = Yii::$app->request->post();
        if (Yii::$app->getSession()->has('cart') && !empty($post) && !empty($post['i'])) {
            $cart = Yii::$app->getSession()->get('cart');
            $totals = 0;
            
            $userid = Yii::$app->user->getId();
            $payment_to = 0;
            
            $order = new Orders();
            $order->user_id = $userid;
            $order->totals = 0;
            $order->status = Orders::STATUS_PENDING;
            $order->payment_status  = Orders::UNPAID;
            $order->notes = $post['notes'];
            $order->save();

            $i = 1;
            $x = 0;
            
            foreach($post['entry'] as $item){
                if(($boardEntry = BoardEntry::findOne($item))!==null ){
                    $payment_to = $boardEntry->user_id;
                    $orderItem = new OrdersItem();

                    $qty = !empty($post['qty'][$x])?$post['qty'][$x]:1;
                    
                    $orderItem->orders_id = $order->id;
                    $orderItem->board_entry_id = $boardEntry->id;
                    $orderItem->qty = $qty;
                    $orderItem->price = $boardEntry->price;
                    $total = ($qty * $boardEntry->price);
                    $orderItem->total = $total;

                    $totals = $totals + $total;

                    if($orderItem->save()){
                        $paypal_items['item_name_'.$i] = $boardEntry->name;
                        $paypal_items['quantity_'.$i] = $qty;
                        $paypal_items['amount_'.$i] = $boardEntry->price;
                        $i++;
                    }
                    
                    unset($cart[$item]); //remove from cache checkout
                    Yii::$app->getSession()->set('cart', $cart); // 
                    
                }
                $x++;
            }

            $order->totals = $totals;
            $order->orders_to = $payment_to;
            $order->save();
            
            ///$paypal_items['business'] = Yii::$app->params['business'];
            
            if(($userMeta = UserMeta::findOne(['user_id'=>$payment_to,'meta_key'=>'paypal_email']))!==null){
                $paypal_email = $userMeta->meta_value;
                if(!empty($paypal_email)){
                    $paypal_items['business'] = $paypal_email;
                    $paypal_items['notify_url'] = Yii::$app->urlManager->createAbsoluteUrl('ipn/notify');
                    $paypal_items['return'] = Yii::$app->urlManager->createAbsoluteUrl('checkout/index');
                    $paypal_items['cancel_return'] = Yii::$app->urlManager->createAbsoluteUrl('checkout/index');

                    $paypal_items['custom'] = json_encode([
                        'order_id'=>$order->id,
                        'entries'=>$post['entry'],
                        'payment_from'=>$userid,
                        'payment_to'=>$payment_to,
                        ]);

                    $paypal_items['cmd'] = '_cart';
                    $paypal_items['upload'] = '1';

                    $paypal_items_string = http_build_query($paypal_items);
                    $url = Yii::$app->params['paypal_url'].'?'.$paypal_items_string;

                    return Yii::$app->getResponse()->redirect($url);
                }
            }
            
            $url = Yii::$app->urlManager->createAbsoluteUrl('checkout/index');
            return Yii::$app->getResponse()->redirect($url);
        }
    }


    public function actionInfo()
    {
        $post = Yii::$app->request->post();
        $items = [];
        if(!empty($post) && !empty($post['i'])){
            if (!Yii::$app->getSession()->has('cart')) {
                Yii::$app->getSession()->set('cart', []);
            }
            
            $cart = [];
            $i = 0;
            
            if(!empty($post['entry'])){
                foreach($post['entry'] as $entry){
                    $qty = 1;
                    if(!empty($post['qty'])){
                        $qty = $post['qty'][$i];
                    }

                    $model = $this->findModel($entry);
                    $cart[$entry]=[
                        'board_entry_id'=>$entry,
                        'user_id'=>$model->user_id,
                        'qty'=>$qty
                    ];
                    $i++;
                }
            }
            
            $cart = array_unique($cart, SORT_REGULAR);
            Yii::$app->getSession()->set('cart', $cart);

            $cart = Yii::$app->getSession()->get('cart');
            foreach($cart as $item){
                $items[] = $this->findModel($item['board_entry_id']);
            }
            $model = new CustomerForm();
            $model->id=$post['i'];
            return $this->render('info',['items'=>$items,'cart'=>$cart, 'model'=> $model]);
        }
    }
    
    public function actionCart()
    {
        $post = Yii::$app->request->post();
        if(!empty($post)){
            if (!Yii::$app->getSession()->has('cart')) {
                Yii::$app->getSession()->set('cart', []);
            }
            
            $cart = [];
            $i = 0;
            
            if(!empty($post['entry'])){
                foreach($post['entry'] as $entry){
                    $qty = 1;
                    if(!empty($post['qty'])){
                        $qty = $post['qty'][$i];
                    }
                    $model = $this->findModel($entry);
                    $cart[$entry]=[
                        'board_entry_id'=>$entry,
                        'user_id'=>$model->user_id,
                        'qty'=>$qty
                    ];
                    //$cart[$entry]=['board_entry_id'=>$entry,'qty'=>$qty];
                    $i++;
                }
            }
            
            $cart = array_unique($cart, SORT_REGULAR);
            Yii::$app->getSession()->set('cart', $cart);

            if(!empty($post['redirect'])){
                return Yii::$app->getResponse()->redirect($post['redirect']);
            }
        }
        
        return $this->goHome();
        
    }
    
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
    
    protected function remove()
    {
        $post = Yii::$app->request->post();
        if (!Yii::$app->getSession()->has('cart')) {
            Yii::$app->getSession()->set('cart', []);
        }
        $cart = Yii::$app->getSession()->get('cart');
        unset($cart[$post['i']]);
        
        
        Yii::$app->getSession()->set('cart', $cart);
        return ['status'=>true];
    }
}
