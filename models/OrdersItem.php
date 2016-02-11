<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_item".
 *
 * @property string $id
 * @property string $orders_id
 * @property string $board_entry_id
 * @property integer $qty
 * @property double $price
 * @property double $total
 */
class OrdersItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orders_id', 'board_entry_id', 'qty', 'price', 'total'], 'required'],
            [['orders_id', 'board_entry_id', 'qty'], 'integer'],
            [['price', 'total'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orders_id' => 'Orders ID',
            'board_entry_id' => 'Board Entry ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Total',
        ];
    }
    
    public function getTotalSale($board_entry_id)
    {
        $sql = 'select sum(orders_item.qty) total from orders 
            inner join orders_item on orders_item.orders_id = orders.id
            inner join board_entry on orders_item.board_entry_id = board_entry.id

            where payment_status = '.Orders::PAID. 
            ' and board_entry.id = '.$board_entry_id;
        $ordersItem = OrdersItem::findBySql($sql)->one();
        
        return $ordersItem->total;
    }
    
    public function getBoardEntry()
    {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
    
    public function getOrders() {
        return $this->hasOne(Orders::className(), ['id' => 'orders_id']);
    }
}
