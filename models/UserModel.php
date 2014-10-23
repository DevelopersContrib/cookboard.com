<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $type
 * @property string $datetime_created
 */
class UserModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['type'], 'integer'],
            [['slug','photo'], 'string'],
            [['datetime_created'], 'safe'],
            [['username', 'password', 'email', 'notes', 'authKey'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'type' => 'Type',
            'datetime_created' => 'Datetime Created',
        ];
    }
    
    public function getUserMeta()
    {
        return $this->hasMany(UserMeta::className(), ['user_id' => 'id']);
    }    
}
