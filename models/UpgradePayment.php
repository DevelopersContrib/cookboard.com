<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upgrade_payment".
 *
 * @property string $id
 * @property string $datetime_created
 * @property double $amount
 * @property string $payer_email
 * @property string $status
 * @property string $summary
 * @property string $payment_from
 * @property string $txn_id
 */
class UpgradePayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upgrade_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['amount', 'payer_email', 'status', 'summary', 'payment_from', 'txn_id'], 'required'],
            [['amount'], 'number'],
            [['summary'], 'string'],
            [['payment_from'], 'integer'],
            [['payer_email', 'txn_id'], 'string', 'max' => 128],
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
            'amount' => 'Amount',
            'payer_email' => 'Payer Email',
            'status' => 'Status',
            'summary' => 'Summary',
            'payment_from' => 'Payment From',
            'txn_id' => 'Txn ID',
        ];
    }
}
