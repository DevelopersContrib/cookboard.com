<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cook_board_items".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $board_entry_id
 * @property string $cook_board_pin_id
 */
class CookBoardItems extends \yii\db\ActiveRecord
{
    public $temp_cook_board_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cook_board_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id','cook_board_id'], 'required'],
            [['user_id', 'board_entry_id', 'pin_board_entry_id'], 'integer']
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
            'board_entry_id' => 'Board Entry ID',
            'pin_board_entry_id' => 'Cook Board Pin ID',
        ];
    }
    
    public function beforeValidate()
    {
        if(empty($this->user_id)){
            $this->user_id = Yii::$app->user->getId();
        }
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
    
    public function afterSave($insert, $changedAttributes )
    {
        //update cookboard count
        if($insert){
            $cookboard = CookBoard::findOne($this->cook_board_id);
            $cookboard->update();
        }
        return true;
    }
    
    public function afterDelete()
    {
        $cookboard = CookBoard::findOne($this->temp_cook_board_id);
        $cookboard->update();
        return true;
    }
    
    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
    
    public function getPinBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'pin_board_entry_id']);
    }
    
    public function getCookboard() {
        return $this->hasOne(CookBoard::className(), ['id' => 'cook_board_id']);
    }
}
