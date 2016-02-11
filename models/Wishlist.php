<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $keyword
 * @property string $user_id
 * @property string $city
 * @property string $diet
 * @property string $cuisine
 * @property string $course
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['keyword'], 'required'],
            [['user_id'], 'integer'],
            [['keyword', 'city'], 'string', 'max' => 255],
            [['diet', 'cuisine', 'course'], 'string', 'max' => 128]
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
            'keyword' => 'Keyword',
            'user_id' => 'User ID',
            'city' => 'City',
            'diet' => 'Diet',
            'cuisine' => 'Cuisine',
            'course' => 'Course',
        ];
    }
}
