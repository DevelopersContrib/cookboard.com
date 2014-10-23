<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'http://fonts.googleapis.com/css?family=Raleway:400,500,300',
        'css/index.css',
        'css/menu-nav-custom.css',
        'css/loading.css',
        'css/noti-custom.css',
        'css/inline.css',        
    ];
    public $js = [
        'js/Core.js',
        'js/global.js',
        'js/vendor/dropzone.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
