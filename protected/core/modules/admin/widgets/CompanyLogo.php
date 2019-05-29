<?php

namespace core\modules\admin\widgets;

use yii;
use yii\base\Widget;

/**
 * Description of Company logo
 */
class CompanyLogo extends Widget
{
    public function run()
    {
        $name = Yii::$app->name;
        return $this->render('company-logo', ['name' => $name]);
    }
}
