<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_payment".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $orders_id
 * @property double $amount
 * @property string $payer_email
 * @property string $status
 * @property string $summary
 */
class OrdersPayment extends \yii\db\ActiveRecord
{
    const PAYPAL = 0;
    const POD = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['orders_id', 'amount', 'payment_to', 'status', 'summary'], 'required'],
            [['orders_id','payment_to','payment_from','payment_type'], 'integer'],
            [['amount'], 'number'],
            [['summary'], 'string'],
            [['payer_email', 'txn_id', 'receiver_email'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime_created' => 'Datetime Created',
            'orders_id' => 'Orders ID',
            'amount' => 'Amount',
            'payer_email' => 'Payer Email',
            'status' => 'Status',
            'summary' => 'Summary',
        ];
    }
    
    public function getPaymentTypeText()
    {
        if($this->payment_type===self::POD){
            return 'POD';
        }else{
            return 'PayPal';
        }
    }
    
    public function getOrder() {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id']);
    }
    
    public function getPaymentFrom() {
        return $this->hasOne(UserModel::className(), ['id' => 'payment_from']);
    }
    
    public function getPaymentTo() {
        return $this->hasOne(UserModel::className(), ['id' => 'payment_to']);
    }
}
