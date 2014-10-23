<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_entry_photo".
 *
 * @property string $id
 * @property string $board_entry_id
 * @property string $datetime_created
 * @property string $url
 * @property string $title
 * @property string $description
 * @property integer $seq
 */
class BoardEntryPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_entry_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['board_entry_id', 'photo'], 'required'],
            [['board_entry_id', 'seq'], 'integer'],
            [['datetime_created'], 'safe'],
            [['description'], 'string'],
            [['photo', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'board_entry_id' => 'Board Entry ID',
            'datetime_created' => 'Datetime Created',
            'photo' => 'Photo',
            'title' => 'Title',
            'description' => 'Description',
            'seq' => 'Seq',
        ];
    }
    
    public function getBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
}
