<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price_type".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 */
class PriceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}
