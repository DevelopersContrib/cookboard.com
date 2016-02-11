<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cook_board_pin".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $cook_board_id
 * @property string $board_entry_id
 */
class CookBoardPin extends \yii\db\ActiveRecord
{
    public $temp_cook_board_id;
    public $temp_board_entry_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cook_board_pin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'cook_board_id', 'board_entry_id'], 'required'],
            [['user_id', 'cook_board_id', 'board_entry_id'], 'integer']
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
            'cook_board_id' => 'Cook Board ID',
            'board_entry_id' => 'Board Entry ID',
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
        //update cookboard count
        if($insert){
            $cookboardItems = new CookBoardItems();
            $cookboardItems->user_id = Yii::$app->user->getId();
            $cookboardItems->cook_board_id = $this->cook_board_id;
            $cookboardItems->pin_board_entry_id = $this->board_entry_id;
            $cookboardItems->save();
            
            $cookboard = CookBoard::findOne($this->cook_board_id);
            $cookboard->update();
        }
        return true;
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->temp_cook_board_id = $this->cook_board_id;
            $this->temp_board_entry_id = $this->board_entry_id;
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        if(($cookboardItem = CookBoardItems::findOne(['pin_board_entry_id'=>$this->board_entry_id,
            'cook_board_id'=>$this->temp_cook_board_id,'user_id'=>Yii::$app->user->getId()]))!==null){
                $cookboardItem->delete();
            }
            
        $cookboard = CookBoard::findOne($this->temp_cook_board_id);
        $cookboard->update();
        return true;
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCookboard() {
        return $this->hasOne(CookBoard::className(), ['id' => 'cook_board_id']);
    }
    
    public function getBoardEntry()
    {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
}
