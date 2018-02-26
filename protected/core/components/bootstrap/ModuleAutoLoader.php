<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

/**
 * ModuleAutoLoader automatically searches for autostart.php files in module folder an executes them.
 */
class ModuleAutoLoader implements BootstrapInterface
{

    const CACHE_ID = 'module_configs';

    /**
     * Auto load modules to application,if application in prod environment, cache modules config.
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $modules = Yii::$app->cache->get(self::CACHE_ID);

        if ($modules === false) {
            $modules = [];
            foreach (Yii::$app->params['moduleAutoloadPaths'] as $modulePath) {
                $modulePath = Yii::getAlias($modulePath);
                foreach (scandir($modulePath) as $moduleId) {
                    if ($moduleId == '.' || $moduleId == '..')
                        continue;

                    $moduleDir = $modulePath . DIRECTORY_SEPARATOR . $moduleId;
                    $moduleConfig = $moduleDir . DIRECTORY_SEPARATOR . 'config.php';
                    if (is_dir($moduleDir) && is_file($moduleConfig)) {
                        try {
                            $modules[$moduleDir] = require($moduleConfig);
                        } catch (\Exception $ex) {

                        }
                    }
                }
            }
            if (!YII_DEBUG) {
                Yii::$app->cache->set(self::CACHE_ID, $modules);
            }
        }

        Yii::$app->moduleManager->registerBulk($modules);
    }

}
