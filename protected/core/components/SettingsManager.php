<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components;

use Yii;
use core\libs\BaseSettingsManager;

/**
 * SettingsManager application component
 */
class SettingsManager extends BaseSettingsManager
{
    /**
     * Indicates this setting is fixed in configuration file and cannot be
     * changed at runtime.
     *
     * @param string $name
     * @return boolean
     */
    public function isFixed($name)
    {
        return isset(Yii::$app->params['fixed-settings'][$this->moduleId][$name]);
    }

    /**
     * @inheritdoc
     */
    public function get($name, $default = null)
    {
        if ($this->isFixed($name)) {
            return Yii::$app->params['fixed-settings'][$this->moduleId][$name];
        }

        return parent::get($name, $default);
    }

}
