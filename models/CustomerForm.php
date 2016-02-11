<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class CustomerForm extends Model
{
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $address;
    public $zip;
    public $contact_number;

    public function rules()
    {
        return [
            [['id', 'email', 'first_name', 'last_name', 'address', 'zip', 'contact_number'], 'required'],
        ];
    }

}
