<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\modules\home\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HomeAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/default';
    public $baseUrl = '@web/themes/default';
    public $css = [
        'css/bootstrap.min.css',
        'css/animate.min.css',
        'css/font-awesome.min.css',
        'css/lightbox.css',
        'css/main.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquery.js',
        'js/bootstrap.min.js',
        'js/jquery.inview.min.js',
        'js/wow.min.js',
        'js/jquery.countTo.js',
        'js/lightbox.min.js',
        'js/main.js',
        'js/swich_ico.js',
    ];
}
