<?php
namespace app\assets;
use yii\web\AssetBundle;

class ValidationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset'
    ];
}
