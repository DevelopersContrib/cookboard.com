<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_entry_photo".
 *
 * @property string $photo

 */
class Photo extends \yii\db\ActiveRecord
{
    public $photo;
    public function rules()
    {
        return [
            [['photo'], 'safe'],
            [['photo'], 'file', 'extensions'=>'jpg, gif, png']
        ];
    }

    
}
