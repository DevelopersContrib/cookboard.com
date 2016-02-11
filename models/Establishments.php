<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper; // load classes
/**
 * This is the model class for table "establishments".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $name
 * @property string $type
 * @property string $location
 * @property string $review
 * @property integer $rating
 * @property string $user_id
 */
class Establishments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'establishments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['name','photo', 'type', 'location', 'review', 'rating', 'user_id'], 'required'],
            [['type', 'rating', 'user_id'], 'integer'],
            [['review'], 'string'],
            [['name', 'slug','photo','location'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'type' => 'Type',
            'location' => 'Location',
            'review' => 'Review',
            'rating' => 'Rating',
            'user_id' => 'User ID',
        ];
    }
    
    public function beforeValidate()
    {
        if(empty($this->user_id)){
            $this->user_id = Yii::$app->user->getId();
        }
        return true;
    }
    
    public function afterSave($insert, $changedAttributes )
    {
        if(isset($changedAttributes['name']) || $insert){
            $slug = Yii::$app->z->create_url_slug($this->name);
            $this->slug = $slug.'-'.$this->id;
            $this->save();
        }
        
        return false;
    }
    
    public function getEstablishmentsType() {
        return $this->hasOne(EstablishmentsType::className(), ['id' => 'type']);
    }
    public function getTypeList() { 
        return ArrayHelper::map(EstablishmentsType::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
}
