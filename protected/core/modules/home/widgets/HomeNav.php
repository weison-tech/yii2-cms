<?php
/**
 * ================================================================
 * @author xiaomalover <xiaomalover@gmail.com>
 * @link http://www.itweshare.com
 */
namespace core\modules\home\widgets;

use core\modules\home\models\Company;
use yii\base\Widget;

class HomeNav extends Widget
{
    public $items;

    public function run()
    {
        $company = Company::find()->where(['id' => 1])->one();
        if ($company && $company->img) {
            $logo_url = $company->img->getOriginImageUrl();
        } else {
            $logo_url = '/themes/default/images/logo.png';
        }

        return $this->render('home-nav', ['items' => $this->items, 'logo_url' => $logo_url]);
    }
}
