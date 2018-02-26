<?php
/**
 * ================================================================
 * @author xiaomalover <xiaomalover@gmail.com>
 * @link http://www.itweshare.com
 */
namespace core\modules\home\widgets;

use core\modules\home\models\Company;
use core\modules\home\models\Link;
use yii\base\Widget;
use core\models\Category;
use yii\helpers\Url;

class Footer extends Widget
{
    public $items;

    public function run()
    {
        $items = [];

        $products_cat = Category::find()
            ->where(['status' => Category::STATUS_ENABLED, 'type' => Category::TYPE_PRODUCT])
            ->orderBy('sort_order asc')
            ->limit(10)
            ->all();
        $pro_cat =  [
            'main' => [
                'title' => '案例',
                'url' => Url::to(['/products']),
            ],
            'child' => [],
        ];
        foreach ($products_cat as $v) {
            $item = [
                'title' => $v->name,
                'url' => Url::to(['/products', 'id' => $v->id]),
            ];
            $pro_cat['child'][] = $item;
        }
        $items[] = $pro_cat;

        $services_cat = Category::find()
            ->where([
                'status' => Category::STATUS_ENABLED,
                'type' => Category::TYPE_SERVICES,
                'parent_id' => 0,
            ])->orderBy('sort_order asc')
            ->limit(10)
            ->all();
        $sev_cat =  [
            'main' => [
                'title' => '服务',
                'url' => Url::to(['/services']),
            ],
            'child' => [],
        ];
        foreach ($services_cat as $v) {
            $item = [
                'title' => $v->name,
                'url' => Url::to(['/services']),
            ];
            $sev_cat['child'][] = $item;
        }
        $items[] = $sev_cat;

        $about_cat = [
            'main' => [
                'title' => '关于',
                'url' => url::to(['/about']),
            ],
            'child' => [
                [
                    'title' => '公司简介',
                    'url' => Url::to(['/about']),
                ] ,
                [
                    'title' => '观点',
                    'url' => Url::to(['/about']),
                ]
            ],
        ];
        $items[] = $about_cat;

        $news_cat = Category::find()
            ->where(['status' => Category::STATUS_ENABLED, 'type' => Category::TYPE_NEWS])
            ->orderBy('sort_order asc')
            ->limit(10)
            ->all();
        $ns_cat =  [
            'main' => [
                'title' => '动态',
                'url' => Url::to(['/news']),
            ],
            'child' => [],
        ];
        foreach ($news_cat as $v) {
            $item = [
                'title' => $v->name,
                'url' => Url::to(['/news', 'id' => $v->id]),
            ];
            $ns_cat['child'][] = $item;
        }
        $items[] = $ns_cat;

        $links = Link::find()
            ->where(['status' => Link::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->limit(10)
            ->all();

        $company = Company::find()->where(['id' => 1])->one();
        if ($company && $company->img) {
            $logo_url = $company->img->getOriginImageUrl();
        } else {
            $logo_url = '/themes/default/images/logo.png';
        }

        return $this->render('footer', ['items' => $items, 'links' => $links, 'logo_url' => $logo_url]);
    }
}
