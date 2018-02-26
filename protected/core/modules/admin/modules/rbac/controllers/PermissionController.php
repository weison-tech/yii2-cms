<?php

namespace core\modules\admin\modules\rbac\controllers;

use yii\rbac\Item;
use core\modules\admin\modules\rbac\base\ItemController;

/**
 * Class PermissionController
 *
 * @package core\modules\admin\modules\rbac\controllers
 */
class PermissionController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_PERMISSION;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Permission',
        'Items' => 'Permissions',
    ];
}
