<?php

namespace core\modules\admin\modules\rbac\controllers;

use Yii;
use yii\filters\VerbFilter;
use core\modules\admin\components\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use core\modules\admin\modules\rbac\models\RouteModel;

/**
 * Class RouteController
 *
 * @package core\modules\admin\modules\rbac\controllers
 */
class RouteController extends Controller
{
    /**
     * @var array route model class
     */
    public $modelClass = [
        'class' => RouteModel::class,
    ];

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors =  [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'create' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove', 'refresh'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
        return ArrayHelper::merge($behaviors, parent::behaviors());
    }

    /**
     * Lists all Route models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Yii::createObject($this->modelClass);

        return $this->render('index', ['routes' => $model->getRoutes()]);
    }

    /**
     * Assign routes
     *
     * @return array
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->addNew($routes);

        return $model->getRoutes();
    }

    /**
     * Remove routes
     *
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->remove($routes);

        return $model->getRoutes();
    }

    /**
     * Refresh cache of routes
     */
    public function actionRefresh()
    {
        $model = Yii::createObject($this->modelClass);
        $model->invalidate();

        return $model->getRoutes();
    }
}
