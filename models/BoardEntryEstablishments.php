<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_entry_establishments".
 *
 * @property string $id
 * @property string $board_entry_id
 * @property string $establishments_id
 */
class BoardEntryEstablishments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_entry_establishments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['board_entry_id', 'establishments_id'], 'required'],
            [['board_entry_id', 'establishments_id'], 'integer']
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
            'establishments_id' => 'Establishments ID',
        ];
    }
	
	public function getEstablishments() {
        return $this->hasOne(Establishments::className(), ['id' => 'establishments_id']);
    }
	
	public function getBoardEntry() {
        return $this->hasOne(BoardEntry::className(), ['id' => 'board_entry_id']);
    }
}
