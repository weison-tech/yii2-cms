<?php

use core\modules\admin\widgets\AdminMenu;

return [
    'id' => 'home',
    'class' => \core\modules\home\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => ['core\modules\home\Events', 'onAdminMenuInit']],
    ],
    'modules' => [
        'admin' => [
            'class' => 'core\modules\home\admin\Module',
        ],
    ],
];
