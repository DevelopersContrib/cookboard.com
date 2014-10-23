<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper; // load classes
/**
 * This is the model class for table "board_entry".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $description
 * @property string $cuisine_id
 * @property string $course_id
 * @property string $diet_id
 * @property string $city
 * @property integer $rating
 * @property string $delivery_type_id
 * @property double $price
 */
class BoardEntry extends \yii\db\ActiveRecord
{
    public $temp_cook_board_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'cook_board_id', 'price_type_id', 'name', 'description', 'cuisine_id', 'course_id', 'city', 'delivery_type_id', 'price'], 'required'],
            [['user_id', 'cook_board_id', 'cuisine_id', 'course_id', 'diet_id', 'rating', 'delivery_type_id'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['city'], 'string', 'max' => 128],
            [['price_type_id'], 'string', 'max' => 10],
            [['name', 'slug'], 'string', 'max' => 255]
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
            'user_id' => 'User',
            'name' => 'Title',
            'description' => 'Description',
            'cuisine_id' => 'Cuisine',
            'course_id' => 'Course',
            'cook_board_id' => 'Cook Board',
            'diet_id' => 'Diet',
            'city' => 'City',
            'rating' => 'Rating',
            'delivery_type_id' => 'Delivery Type',
            'price_type_id' => 'Price Type',
            'price' => 'Price',
        ];
    }
    
    public function beforeValidate()
    {
        if(empty($this->user_id)){
            $this->user_id = Yii::$app->user->getId();
        }
        $this->slug = Yii::$app->z->create_url_slug($this->name);
        return true;
    }
    
    public function afterSave($insert, $changedAttributes )
    {   
        $cookboard = CookBoard::findOne($this->cook_board_id);
        $cookboard->update();
        return true;
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->temp_cook_board_id = $this->cook_board_id;
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        $cookboard = CookBoard::findOne($this->temp_cook_board_id);
        $cookboard->update();
        return true;
    }
    
    public function isPinned() {
        return CookBoardPin::find()->where(['board_entry_id' => $this->id,
                    'user_id'=>Yii::$app->user->getId()])->count()>0;
    }
    
    public function getCookBoardPin() {
        return $this->hasMany(CookBoardPin::className(), [
            'board_entry_id' => 'id',
            //'cook_board_id' => 'cook_board_id',
            //'user_id' => Yii::$app->user->getId(),
            ]);
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCookboard() {
        return $this->hasOne(CookBoard::className(), ['id' => 'cook_board_id']);
    }
    
    public function getCuisine() {
        return $this->hasOne(Cuisine::className(), ['id' => 'cuisine_id']);
    }
    public function getCuisineList() { 
        return ArrayHelper::map(Cuisine::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getCourse() {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
    public function getCourseList() {
        return ArrayHelper::map(Course::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getDiet() {
        return $this->hasOne(Diet::className(), ['id' => 'diet_id']);
    }
    public function getDietList() {
        return ArrayHelper::map(Diet::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getDeliveryType() {
        return $this->hasOne(DeliveryType::className(), ['id' => 'delivery_type_id']);
    }
    public function getDeliveryTypeList() { 
        return ArrayHelper::map(DeliveryType::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getPriceType() {
        return $this->hasOne(PriceType::className(), ['id' => 'price_type_id']);
    }
    public function getPriceTypeList() { 
        return ArrayHelper::map(PriceType::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getBoardEntryPhoto()
    {
        return $this->hasMany(BoardEntryPhoto::className(), ['board_entry_id' => 'id']);
    }    
    public function getBoardEntryPhotoList() { 
        return ArrayHelper::map(BoardEntryPhoto::find()->where(['board_entry_id'=>$this->id])->asArray()->all(), 'id', 'photo');
    }
    
    public function getPhotoCount(){
        return BoardEntryPhoto::find()->where(['board_entry_id'=>$this->id])->count();
    }
    
}
