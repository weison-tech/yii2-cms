<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\widgets;

use Yii;

/**
 * LanguageChooser
 */
class LanguageChooser extends \yii\base\Widget
{

    /**
     * Displays / Run the Widget
     */
    public function run()
    {
        $model = new \core\models\forms\ChooseLanguage();
        $model->language = Yii::$app->language;
        return $this->render('languageChooser', ['model' => $model, 'languages' => Yii::$app->i18n->getAllowedLanguages()]);
    }

}
