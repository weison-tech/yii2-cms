<?php

$config = [
    'id' => 'basic',
    'bootstrap' => ['core\components\bootstrap\LanguageSelector'],
    'defaultRoute' => '/home/index/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-gNKYqb_o_977zXvr20qSpO0DXmZ3YQP',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'core\modules\user\models\User',
            'enableAutoLogin' => true,
            'authTimeout' => 1400,
            'loginUrl' => ['/user/index/login'],
            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],
            'idParam' => '__user',
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'core\modules\admin\models\Admin',
            'enableAutoLogin' => true,
            'authTimeout' => 1400,
            'loginUrl' => ['/admin/index/login'],
            'identityCookie' => ['name' => '__admin_identity', 'httpOnly' => true],
            'idParam' => '__admin',
        ],
        'errorHandler' => [
            'errorAction' => '/home/index/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'linkAssets' => true,
            'bundles' => require(__DIR__ . '/' . (YII_ENV_PROD ? 'assets-prod.php' : 'assets-dev.php')),
        ],
    ],

    'modules' => [],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] =  $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [
                'class' => 'core\modules\admin\gii\crud\Generator',
                'templates' => [
                    'agent' => '@core/modules/admin/gii/crud/simple',
                ]
            ],
        ],
    ];
}

return $config;
