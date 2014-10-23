<?php
namespace app\assets;

use yii\web\AssetBundle;

class HomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'http://fonts.googleapis.com/css?family=Raleway:400,500,300',
        'css/index.css',
        'css/menu-nav-custom.css',
    ];
    public $js = [
        'js/Core.js',
        'js/vendor/dropzone.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
