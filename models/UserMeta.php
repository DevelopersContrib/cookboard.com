<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_meta".
 *
 * @property string $id
 * @property string $user_id
 * @property string $meta_key
 * @property string $meta_value
 */
class UserMeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'meta_key'], 'required'],
            [['user_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
    
    public function afterSave($insert, $changedAttributes )
    {   
        if(!empty($changedAttributes) && ($userid = Yii::$app->user->getId())!==null 
            && ($user = UserModel::findOne($userid))!==null
                ){
            
            $first_name = '';
            $last_name = '';
            
            $slug = $userid ;
            if(($um = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'first_name']))!==null){
                $slug = $um->meta_value;
                $first_name = $um->meta_value;
            }
            if(($um = UserMeta::findOne([ 'user_id' => $userid,'meta_key'=>'last_name']))!==null){
                $slug .= $um->meta_value;
                $last_name = $um->meta_value;
            }

            if(UserModel::findOne(['slug'=>$slug])!==null && $slug !==$user->slug){
                $slug = $slug.'-'.$userid;
            }
            
            if(!empty($last_name) || !empty($first_name)){
                $user->username = trim($first_name.' '.$last_name);
            }
            
            $user->slug = Yii::$app->z->create_url_slug($slug);
            $user->update();
        }
        return true;
    }
}
