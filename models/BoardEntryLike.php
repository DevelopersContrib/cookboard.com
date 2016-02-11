<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_entry_like".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $user_id
 * @property string $board_entry_id
 */
class BoardEntryLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_entry_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['user_id', 'board_entry_id'], 'required'],
            [['user_id', 'board_entry_id'], 'integer']
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
        ];
    }
    
    public function getUser() {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    
    public function getBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
}
