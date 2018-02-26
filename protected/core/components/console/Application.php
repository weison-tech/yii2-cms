<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components\console;

use Yii;
use yii\console\Exception;

/**
 * Application for console
 * @package core\console
 */
class Application extends \yii\console\Application
{
    /**
     * @event ActionEvent an event raised on init of application.
     */
    const EVENT_ON_INIT = 'onInit';

    public function init()
    {
        if (version_compare(phpversion(), '5.6', '<')) {
            throw new Exception('Installed PHP Version is too old! Required minimum version is PHP 5.6 (Installed: '
                . phpversion() . ')');
        }

        parent::init();
        $this->trigger(self::EVENT_ON_INIT);

        if ($this->isDatabaseInstalled()) {
            $baseUrl = Yii::$app->settings->get('baseUrl');
            if (!empty($baseUrl)) {

                if (Yii::getAlias('@web', false) === false) {
                    Yii::setAlias('@web', $baseUrl);
                }
                if (Yii::getAlias('@web-static', false) === false) {
                    Yii::setAlias('@web-static', '@web/static');
                }
                if (Yii::getAlias('@webroot-static', false) === false) {
                    Yii::setAlias('@webroot-static', '@webroot/static');
                }
                $this->urlManager->scriptUrl = $baseUrl;
                $this->urlManager->baseUrl = $baseUrl;

                // Set hostInfo based on given baseUrl
                $urlParts = parse_url($baseUrl);
                $hostInfo = $urlParts['scheme'] . '://' . $urlParts['host'];
                if (isset($urlParts['port'])) {
                    $hostInfo .= ':' . $urlParts['port'];
                }

                $this->urlManager->hostInfo = $hostInfo;
            }
        }
    }

    /**
     * Checks if database is installed
     * @return boolean is database installed/migrated
     */
    public function isDatabaseInstalled()
    {
        if (in_array('setting', Yii::$app->db->schema->getTableNames())) {
            return true;
        }

        return false;
    }
}
