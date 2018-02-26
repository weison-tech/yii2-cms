<?php

use core\modules\admin\widgets\AdminMenu;

return [
    'id' => 'products',
    'class' => \core\modules\products\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => ['core\modules\products\Events', 'onAdminMenuInit']],
    ],
    'modules' => [
        'admin' => [
            'class' => 'core\modules\products\admin\Module',
        ],
    ],
];
