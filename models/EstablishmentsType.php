<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper; // load classes
/**
 * This is the model class for table "establishments_type".
 *
 * @property string $id
 * @property string $nam
 */
class EstablishmentsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'establishments_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nam'], 'required'],
            [['nam'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nam' => 'Nam',
        ];
    }
}
