<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_entry_rating".
 *
 * @property string $id
 * @property string $datetime_created
 * @property string $board_entry_id
 * @property string $user_id
 * @property integer $rating
 */
class BoardEntryRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'board_entry_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_created'], 'safe'],
            [['board_entry_id', 'user_id', 'rating'], 'required'],
            [['board_entry_id', 'user_id', 'rating'], 'integer']
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
            'board_entry_id' => 'Board Entry ID',
            'user_id' => 'User ID',
            'rating' => 'Rating',
        ];
    }
    
    public function afterSave($insert, $changedAttributes )
    {
        $ratingCount = BoardEntryRating::find()->where(['board_entry_id'=>$this->board_entry_id])->count();
        $boardEntry = BoardEntry::findOne($this->board_entry_id);
        $boardEntry->rating = floatval($boardEntry->rating) + $this->rating;
        $boardEntry->rating_count = $ratingCount;
        $boardEntry->update();
        return true;
    }
}
