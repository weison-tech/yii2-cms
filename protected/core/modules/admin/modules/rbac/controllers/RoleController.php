<?php

namespace core\modules\admin\modules\rbac\controllers;

use yii\rbac\Item;
use core\modules\admin\modules\rbac\base\ItemController;

/**
 * Class RoleController
 *
 * @package core\modules\admin\modules\rbac\controllers
 */
class RoleController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_ROLE;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Role',
        'Items' => 'Roles',
    ];
}
