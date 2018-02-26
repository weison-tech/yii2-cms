<?php
namespace core\modules\file\widgets;

use yii\web\AssetBundle;

class BlueimpTmplAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-tmpl';

    public $js = [
        'js/tmpl.min.js'
    ];
}
