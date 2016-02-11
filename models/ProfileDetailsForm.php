<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ProfileDetailsForm extends Model
{
    public $first_name;
    public $last_name;
    
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],

        ];
    }

}
