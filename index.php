<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/protected/vendor/autoload.php');
require(__DIR__ . '/protected/vendor/yiisoft/yii2/Yii.php');

//Dynamic config file is created by application.
$dynamic_config = __DIR__ . '/protected/core/config/dynamic.php';

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/protected/core/config/common.php'),
    require(__DIR__ . '/protected/core/config/web.php'),
    (is_readable($dynamic_config)) ? require($dynamic_config) : []
);

$application = new core\components\Application($config);

$application->run();
