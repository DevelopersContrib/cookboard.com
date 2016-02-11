<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $board_entry_id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $message
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'board_entry_id', 'user_id'], 'integer'],
            [['datetime_created'], 'safe'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'board_entry_id' => 'Board Entry ID',
            'datetime_created' => 'Datetime Created',
            'user_id' => 'User ID',
            'message' => 'Message',
        ];
    }
	
	public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
}
