<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components;

use yii;
use yii\web\View as BaseView;

/**
 * @inheritdoc
 */
class View extends BaseView
{
    private $pageTitle;

    /**
     * Sets current page title
     *
     * @param string $title
     */
    public function setPageTitle($title)
    {
        $this->pageTitle = $title;
    }

    /**
     * Returns current page title
     *
     * @return string the page title
     */
    public function getPageTitle()
    {
        return (($this->pageTitle) ? $this->pageTitle . " - " : '') . Yii::$app->name;
    }

    /**
     * Registers a Javascript variable
     *
     * @param string $name
     * @param string $value
     * @param integer $position
     */

    public function registerJsVar($name, $value, $position = BaseView::POS_HEAD)
    {
        $jsCode = "var " . $name . " = '" . addslashes($value) . "';\n";
        $this->registerJs($jsCode, $position, $name);
    }
}
