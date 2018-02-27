<?php

namespace core\modules\home\admin\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use core\modules\home\models\Company;
use core\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class CompanyController extends Controller
{
    public function actions()
    {
        return [
            'ue-upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => Url::to('/', true),
                    "imagePathFormat" => "/uploads/ueditor/{yyyy}{mm}{dd}/{time}{rand:6}",
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return ArrayHelper::merge($behaviors, [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Company::find()->one();

        if (!$model) {
            $model = new Company();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('HomeModule.controllers_CompanyController', 'Update successfully.')
            );
            return $this->redirect(['index']);
        }

        return $this->render('index', ['model' => $model]);
    }
}
