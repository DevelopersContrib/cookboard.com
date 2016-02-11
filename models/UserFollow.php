<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_follow".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $following
 */
class UserFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'following'], 'required'],
            [['user_id', 'following'], 'integer']
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
            'following' => 'Following',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getFollowingUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'following']);
    }
}
