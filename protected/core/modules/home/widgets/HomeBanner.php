<?php
/**
 * ================================================================
 * @author xiaomalover <xiaomalover@gmail.com>
 * @link http://www.itweshare.com
 */
namespace core\modules\home\widgets;

use yii\base\Widget;
use core\modules\home\models\Banner;

class HomeBanner extends Widget
{
    public function run()
    {
        $items = Banner::find()
            ->where(['status' => Banner::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->limit(5)
            ->all();
        return $this->render('home-banner', ['items' => $items]);
    }
}
