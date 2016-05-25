<?php
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper; // load classes
/**
 * This is the model class for table "cook_board".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $name
 * @property string $description
 * @property integer $featured
 * @property string $image
 */
class CookBoard extends \yii\db\ActiveRecord
{
    const FEATURED = 1;
    const NOT_FEATURED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cook_board';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'name', 'description'], 'required'],
            [['user_id', 'featured'], 'integer'],
            [['description'], 'string'],
            [['name', 'slug','facebook','instagram','pinterest'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'description' => 'Description',
            'featured' => 'Featured',
            'image' => 'Image',
        ];
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
    
        
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$this->isNewRecord){ //update only
                $this->countBoard();
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function afterSave($insert, $changedAttributes )
    {
        if(isset($changedAttributes['name']) || $insert){
            $slug = Yii::$app->z->create_url_slug($this->name);
            $this->slug = $slug.'-'.$this->id;
            $this->save();
        }
        
        $boardEntries = BoardEntryPost::find()->where(['cook_board_id'=>$this->id])->orderBy('id')->all();
        
        $i = 1;
        foreach($boardEntries as $entry){
            $entry->seq = $i;
            $entry->update();
            $i++;
        }
        
        return false;
    }
    
	public function countPins(){
        $cook_board_id = $this->id;
        
        return CookBoardItems::find()
            ->where(['cook_board_id' => $cook_board_id])
			->andWhere(['>', 'pin_board_entry_id', 0])
            ->count();
    }
	
	public function countBoardEntries(){
        $cook_board_id = $this->id;
        
        return CookBoardItems::find()
            ->where(['cook_board_id' => $cook_board_id])
			->andWhere(['>', 'board_entry_id', 0])
            ->count();
        
    }
	
	public function countPosts(){
        $cook_board_id = $this->id;
        
        return CookBoardItems::find()
			->innerJoinWith('boardEntry', false)
            ->where(['cook_board_items.cook_board_id' => $cook_board_id, 'board_entry.post_type'=>1])
			->andWhere(['>', 'board_entry_id', 0])			
            ->count();
    }
	
	public function countForSale(){
        $cook_board_id = $this->id;
        
        return CookBoardItems::find()
			->innerJoinWith('boardEntry', false)
            ->where(['cook_board_items.cook_board_id' => $cook_board_id, 'board_entry.post_type'=>0])
			->andWhere(['>', 'board_entry_id', 0])			
            ->count();
    }
	
    public function countBoard(){
        $cook_board_id = $this->id;
        
        $count = CookBoardItems::find()
            ->where(['cook_board_id' => $cook_board_id])
            ->count();
        $this->board_count = $count;
//        $count = BoardEntry::find()
//            ->where(['cook_board_id' => $cook_board_id])
//            ->count();
//
//        $pin_count = CookBoardPin::find()
//            ->where(['cook_board_id'=>$cook_board_id])
//            ->count();

//        $this->board_count = $count + $pin_count;
    }

//    public function getBars()
//    {
//        return $this->hasMany(Bar::className(), ['id' => 'bar_id'])
//            ->viaTable('tbl_foo_bar', ['foo_id' => 'id']);
//    }

    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
	
	public function getPrimary() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'primary_board_entry_id']);
    }
    
    public function getItems()
    {
        return $this->hasMany(CookBoardItems::className(), ['cook_board_id' => 'id']);
    } 
    
    public function getBoardEntry()
    {
        return $this->hasMany(BoardEntry::className(), ['cook_board_id' => 'id']);
    }    
    public function getBoardEntryList() { 
        return ArrayHelper::map(BoardEntry::find()
            ->where(['cook_board_id'=>$this->id])
            ->asArray()->all(), 'id', 'name');
    }
    
    public function getCookBoardPin() {
        return $this->hasMany(CookBoardPin::className(), [
            'cook_board_id' => 'id',
            ]);
    }

}
