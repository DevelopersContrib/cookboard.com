<?php
namespace app\components;

class Safecontroller extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
}