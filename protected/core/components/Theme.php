<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components;

use Yii;
use yii\helpers\FileHelper;

/**
 * @inheritdoc
 */
class Theme extends \yii\base\Theme
{

    const VARIABLES_CACHE_ID = 'theme_variables';

    /**
     * Name of the Theme
     *
     * @var string
     */
    public $name;

    /**
     * @inheritdoc
     */
    private $_baseUrl = null;

    /**
     * Indicates that resources should be published via assetManager
     */
    public $publishResources = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->getBasePath() == '') {
            $this->setBasePath('@webroot/themes/' . $this->name);
        }
        $this->pathMap = [
            '@core/views' => $this->getBasePath() . '/views',
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl()
    {
        if ($this->_baseUrl !== null) {
            return $this->_baseUrl;
        }

        $this->_baseUrl = ($this->publishResources) ?
            $this->publishResources() :
            rtrim(Yii::getAlias('@web/themes/' . $this->name), '/');
        return $this->_baseUrl;
    }

    /**
     * This method will be called before when this theme is written to the
     * dynamic configuration file.
     */
    public function beforeActivate()
    {
        // Force republish theme files
        $this->publishResources(true);
    }

    /**
     * @inheritdoc
     */
    public function applyTo($path)
    {
        $autoPath = $this->autoFindModuleView($path);
        if ($autoPath !== null && file_exists($autoPath)) {
            return $autoPath;
        }

        // Web Resource e.g. image
        if (substr($path, 0, 5) === '@web/' || substr($path, 0, 12) === '@web-static/') {
            $themedFile = str_replace(['@web/', '@web-static/'],
                [$this->getBasePath(), $this->getBasePath() . DIRECTORY_SEPARATOR . 'static'], $path);
            // Check if file exists in theme base dir
            if (file_exists($themedFile)) {
                return str_replace(['@web/', '@web-static/'],
                    [$this->getBaseUrl(), $this->getBaseUrl() . DIRECTORY_SEPARATOR . 'static'], $path);
            }
            return $path;
        }

        return parent::applyTo($path);
    }

    /**
     * Publish theme assets (e.g. images or css)
     *
     * @param boolean|null $force
     * @return string url of published resources
     */
    public function publishResources($force = null)
    {
        if ($force === null) {
            $force = (YII_DEBUG);
        }

        $published = Yii::$app->assetManager->publish(
            $this->getBasePath(), ['forceCopy' => $force, 'except' => ['views/']]
        );

        return $published[1];
    }

    /**
     * Tries to automatically maps the view file of a module to a themed one.
     *
     * Formats:
     *   .../moduleId/views/controllerId/viewName.php
     *   to:
     *   .../views/moduleId/controllerId/viewName.php
     *
     *   .../moduleId/[widgets|...]/views/viewName.php
     *   to:
     *   .../views/moduleId/[widgets|activities|notifications]/viewName.php
     * @param string $path
     * @return string theme view path or null
     */
    protected function autoFindModuleView($path)
    {
        $sep = preg_quote(DIRECTORY_SEPARATOR);
        $path = FileHelper::normalizePath($path);

        // .../moduleId/views/controllerId/viewName.php
        if (preg_match(
            '@.*' . $sep . '(.*?)' . $sep . 'views' . $sep . '(.*?)' . $sep . '(.*?)\.php$@',
            $path,
            $hits
        )) {
            return $this->getBasePath() . '/views/' . $hits[1] . '/' . $hits[2] . '/' . $hits[3] . '.php';
        }

        // /moduleId/[widgets|activities|notifications]/views/viewName.php
        if (preg_match(
            '@.*' . $sep . '(.*?)' . $sep . '(widgets)' . $sep . 'views' . $sep . '(.*?)\.php$@',
            $path,
            $hits
        )) {
            // Handle special case (protected/core/widgets/views/view.php => views/widgets/view.php)
            if ($hits[1] == 'core') {
                return $this->getBasePath() . '/views/' . $hits[2] . '/' . $hits[3] . '.php';
            }
            // Handle other module widgets theme.
            return $this->getBasePath() . '/views/' . $hits[1] . '/' . $hits[2] . '/' . $hits[3] . '.php';
        }

        return null;
    }
}
