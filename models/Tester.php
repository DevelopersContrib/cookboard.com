<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tester".
 *
 * @property string $id
 * @property string $photo
 */
class Tester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo'], 'required'],
            [['photo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
        ];
    }
}
