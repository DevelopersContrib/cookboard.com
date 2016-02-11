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
    const BASIC = 0;
    const ADMIN = 1;
    const PREMIUM = 2;
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
            [['slug','photo','external_id'], 'string'],
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
    
    public function getCookboard()
    {
        return $this->hasMany(CookBoard::className(), ['user_id' => 'id']);
    }
	
	public function getNewmembers()
	{
		$metadata = [];
		if(!empty($this->userMeta)){
			foreach($this->userMeta as $meta){
				$key = $meta->meta_key;
				$value = $meta->meta_value;
				$metadata = array_merge(["$key"=>$value],$metadata);
			}
		}
		
		$location = $metadata['location'];
		$OR = '';
		
		if(!empty($location)){
			$locations = explode(' ',$location);
			foreach($locations as $loc){
				$loc = str_replace(",","",$loc);
				$OR = !empty($OR) ? $OR." OR meta_value LIKE '%$loc%' " : " meta_value LIKE '%$loc%' ";
			}
			$OR = !empty($OR)?" and ($OR)":"";
		}
		
		$sql = "SELECT user_meta.`user_id` AS id, user_meta.`meta_value` FROM user_meta INNER JOIN user ON user_meta.`user_id` = user.id WHERE meta_key = 'location' and user_id <> $this->id $OR ORDER BY user_id DESC LIMIT 10";
		
		return UserModel::findBySql($sql)->all();  
	}
}
