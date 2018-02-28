<?php

namespace core\modules\admin\widgets;

use yii;
use core\modules\home\models\Company;
use yii\base\Widget;

/**
 * Description of Company logo
 */
class CompanyLogo extends Widget
{
    public function run()
    {
        $name = Yii::$app->name;
        $company = Company::find()->one();
        if ($company) {
            $language = Yii::$app->language;
            if ($language == 'zh_cn') {
                $company->name && $name = $company->name;
            } elseif ($language == 'en') {
                $company->en_name && $name = $company->en_name;
            }
        }

        return $this->render('company-logo', ['name' => $name]);
    }
}
