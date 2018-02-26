<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components\bootstrap;

use yii\base\BootstrapInterface;

/**
 * LanguageSelector automatically sets the language of the i18n component
 *
 * @see \core\components\i18n\I18N
 */
class LanguageSelector implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        mb_internal_encoding('UTF-8');

        $app->i18n->autoSetLocale();
    }
}
