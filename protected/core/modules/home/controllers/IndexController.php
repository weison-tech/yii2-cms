<?php

namespace core\modules\home\controllers;

use core\models\Category;
use core\modules\home\models\Company;
use core\modules\home\models\Contact;
use core\modules\home\models\Link;
use core\modules\home\models\Partner;
use core\modules\news\models\News;
use core\modules\products\models\Products;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class IndexController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $products = Products::find()
            ->where(['status' => Products::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->limit(12)
            ->all();
        $services = Category::find()
            ->where(['status' => Category::STATUS_ENABLED, 'type' => Category::TYPE_SERVICES, 'parent_id' => 0])
            ->orderBy('sort_order asc')
            ->limit(6)
            ->all();

        $about = Company::find()->one();
        $description = ($about && $about->description) ? $about->description : '';

        $partners = Partner::find()->where(['status' => Partner::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->limit(18)
            ->all();

        $news = News::find()->where(['status' => News::STATUS_ENABLED])
            ->orderBy('created_at desc, sort_order asc')
            ->limit(3)
            ->all();

        return $this->render('index',
            [
                'products' => $products,
                'services' => $services,
                'description' => $description,
                'partners' => $partners,
                'news' => $news,
            ]
        );
    }


    /**
     * Displays services page.
     *
     * @return string
     */
    public function actionServices()
    {
        $lists = Category::find()
            ->where(['status' => Category::STATUS_ENABLED, 'type' => Category::TYPE_SERVICES, 'parent_id' => 0])
            ->orderBy('sort_order asc')
            ->limit(6)
            ->all();
        return $this->render('services', ['lists' => $lists]);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $partners = Partner::find()->where(['status' => Partner::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->limit(18)
            ->all();
        $company = Company::find()->one();

        return $this->render('about', ['partners' => $partners, 'company' => $company]);
    }


    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $company = Company::find()->one();

        $links = Link::find()
            ->where(['status' => Link::STATUS_ENABLED])
            ->orderBy('sort_order asc')
            ->all();

        $model = new Contact();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                '已收到您的留言，我们会尽快给你回复。'
            );
            return $this->redirect(['/contact']);
        }

        return $this->render('contact', [
            'company' => $company,
            'links' => $links,
            'model' => $model,
        ]);
    }

}
