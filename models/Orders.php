<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property double $totals
 * @property string $notes
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_DELIVERED = 1;
    const STATUS_CANCELLED = 2;
    
    const UNPAID = 0;
    const PAID = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'totals'], 'required'],
            [['user_id','status','payment_status', 'orders_to'], 'integer'],
            [['totals'], 'number'],
            [['notes'], 'string']
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
            'user_id' => 'User ID',
            'totals' => 'Totals',
            'notes' => 'Notes',
        ];
    }
    
    public function getStatusText()
    {
        if($this->status===self::STATUS_DELIVERED){
            return 'Delivered';
        }elseif($this->status===self::STATUS_CANCELLED){
            return 'Cancelled';
        }else{
            return 'Pending';
        }
    }
    
    public function getPaymentStatusText()
    {
        if($this->payment_status===self::PAID){
            return 'Paid';            
        }else{
            return 'Unpaid';
        }
    }

    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getSeller() {
        return $this->hasOne(UserModel::className(), ['id' => 'orders_to']);
    }
    
    public function getOrdersItem()
    {
        return $this->hasMany(OrdersItem::className(), ['orders_id' => 'id']);
    }    
    
}
