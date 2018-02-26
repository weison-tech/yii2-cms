<?php

use core\modules\admin\widgets\AdminMenu;

return [
    'id' => 'news',
    'class' => \core\modules\news\Module::class,
    'isCoreModule' => true,
    'events' => [
        ['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => ['core\modules\news\Events', 'onAdminMenuInit']],
    ],
    'modules' => [
        'admin' => [
            'class' => 'core\modules\news\admin\Module',
        ],
    ],
];
