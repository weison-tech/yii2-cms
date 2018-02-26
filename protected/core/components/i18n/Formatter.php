<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components\i18n;

use Yii;

/**
 * @inheritdoc
 */
class Formatter extends \yii\i18n\Formatter
{

    /**
     * @inheritdoc
     */
    public $sizeFormatBase = 1000;

    /**
     * @var string the default format string to be used to format a input field [[asDate()|date]].
     * This mostly used in forms (DatePicker).
     * @see dateFormat
     */
    public $dateInputFormat = 'short';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app->getModule('admin')->settings->get('defaultDateInputFormat') != '') {
            $this->dateInputFormat = Yii::$app->getModule('admin')->settings->get('defaultDateInputFormat');
        }
    }

}
