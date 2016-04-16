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
    const POST_TYPE_FOR_SALE = 0;
    const POST_TYPE_STATUS = 1;
    
    public $temp_cook_board_id;
    public $temp_id;
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
            [['user_id', 'cook_board_id', 'post_type', 'price_type_id', 'name', 'description', 'course_id', 'city', 'delivery_type_id', 'price'], 'required'],
            [['user_id', 'seq', 'days_to_prepare', 'rating_count', 'post_type', 'cook_board_id', 'price_type_id', 'cuisine_id', 'course_id', 'diet_id', 'rating', 'delivery_type_id'], 'integer'],
            [['description'], 'string'],
            [['price','rating'], 'number'],
            [['city'], 'string', 'max' => 128],
            //[['price_type_id'], 'string', 'max' => 10],
            [['name', 'slug','latlng'], 'string', 'max' => 255]
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
            'days_to_prepare' => 'Days to Prepare',
            'diet_id' => 'Diet',
            'city' => 'City',
            'rating' => 'Rating',
            'delivery_type_id' => 'Delivery Type',
            'price_type_id' => 'Price Type',
            'price' => 'Price',
        ];
    }
    
    public function prevEntry($parent=false){ //get prev entry under this cookboard
        if($parent===false){
            $items = $this->cookboard->items;
        }else{
            $cookboard = CookBoard::findOne($parent);
            $items = $cookboard->items;
        }
        $return = false;
        $i=0;
        foreach($items as $item){
            if(($item->board_entry_id === $this->id || $item->pin_board_entry_id === $this->id) && $i>0){
                if(!empty($items[$i-1]->board_entry_id))
                    $return = $items[$i-1]->boardEntry;
                else
                    $return = $items[$i-1]->pinBoardEntry;
                break;
            }
            $i++;
        }
        return $return;
    }

    public function nextEntry($parent=false){ //get next entry under this cookboard
        if($parent===false){
            $items = $this->cookboard->items;
        }else{
            $cookboard = CookBoard::findOne($parent);
            $items = $cookboard->items;
        }
        $found = false;
        $return = false;
        foreach($items as $item){
            if($found){
                if(!empty($item->board_entry_id))
                    $return = $item->boardEntry;
                else
                    $return = $item->pinBoardEntry;
                break;
            }
            if($item->board_entry_id === $this->id || $item->pin_board_entry_id === $this->id){
                $found = true;
            }
        }
        return $return;
    }
	
    public function canEdit(){
        return $this->user_id === Yii::$app->user->getId();
    }
    
    public function beforeValidate()
    {
        if(empty($this->user_id)){
            $this->user_id = Yii::$app->user->getId();
        }
        //$this->slug = Yii::$app->z->create_url_slug($this->name);
        return true;
    }
    
    public function afterSave($insert, $changedAttributes )
    {
        //update cookboard count
        if($insert){
            $cookboardItems = new CookBoardItems();
            $cookboardItems->user_id = Yii::$app->user->getId();
            $cookboardItems->cook_board_id = $this->cook_board_id;
            $cookboardItems->board_entry_id = $this->id;
            $cookboardItems->save();
            
            $cookboard = CookBoard::findOne($this->cook_board_id);
            $cookboard->update();
        }
        
        if(isset($changedAttributes['name']) || $insert){
            $slug = Yii::$app->z->create_url_slug($this->name);
            $this->slug = $slug.'-'.$this->id;
            $this->save();
        }
        return true;
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->temp_cook_board_id = $this->cook_board_id;
            $this->temp_id = $this->id;
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        if(($cookboardItem = CookBoardItems::findOne(['board_entry_id'=>$this->temp_id,
            'cook_board_id'=>$this->temp_cook_board_id,'user_id'=>Yii::$app->user->getId()]))!==null){
                $cookboardItem->delete();
            }
        BoardEntryPhoto::deleteAll('board_entry_id = :board_entry_id', [':board_entry_id' => $this->temp_id]);

        $cookboard = CookBoard::findOne($this->temp_cook_board_id);
        $cookboard->update();
        return true;
    }
    
	public function ByCities($limit='')
	{
		
		if(!empty($limit)){
			$limit = " limit $limit";
		}
		/*$criteria = new CDbCriteria();
		if(!empty($limit)){
			$criteria->limit = $limit;
		}
		
		$criteria->distinct=true;
		$criteria->select = 'city';
		return BoardEntry::model()->find($criteria);*/
		$sql = "SELECT DISTINCT city FROM board_entry order by rand() $limit ";
		
		return BoardEntry::findBySql($sql)->all();  
	}
	
    public function isPinned() {
//        return CookBoardPin::find()->where(['board_entry_id' => $this->id,
//            'user_id'=>Yii::$app->user->getId()])->count()>0;
        return CookBoardItems::find()->where(['pin_board_entry_id' => $this->id,
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
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getCookboard() {
        return $this->hasOne(CookBoard::className(), ['id' => 'cook_board_id']);
    }
    
    public function getBoardEntryLike(){
        return $this->hasMany(BoardEntryLike::className(), ['board_entry_id' => 'id']);
    }
	
	public function getReview(){
        return $this->hasMany(Review::className(), ['board_entry_id' => 'id'])->orderBy(['review.id'=>SORT_DESC]);
    }
    
    public function getBoardEntryEstablishments(){
        return $this->hasMany(BoardEntryEstablishments::className(), ['board_entry_id' => 'id']);
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
