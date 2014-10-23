<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property string $id
 * @property string $from_user_id
 * @property string $to_user_id
 * @property string $to_all_user
 * @property string $subject
 * @property string $content
 * @property integer $status
 * @property string $datetime_created
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'to_all_user', 'subject', 'content', 'status'], 'required'],
            [['from_user_id', 'to_user_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['datetime_created'], 'safe'],
            [['to_all_user', 'subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'to_all_user' => 'To All User',
            'subject' => 'Subject',
            'content' => 'Content',
            'status' => 'Status',
            'datetime_created' => 'Datetime Created',
        ];
    }
}
