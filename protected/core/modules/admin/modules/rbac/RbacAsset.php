<?php

namespace core\modules\admin\modules\rbac;

use yii\web\AssetBundle;

/**
 * Class RbacAsset
 *
 * @package core\modules\admin\modules\rbac
 */
class RbacAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@core/modules/admin/modules/rbac/assets';

    /**
     * @var array
     */
    public $js = [
        'js/rbac.js',
    ];

    public $css = [
        'css/rbac.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
