<?php

namespace core\modules\admin\modules\rbac\controllers;

use Yii;
use yii\filters\VerbFilter;
use core\modules\admin\components\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use core\modules\admin\modules\rbac\models\BizRuleModel;
use core\modules\admin\modules\rbac\models\search\BizRuleSearch;

/**
 * Class RuleController
 *
 * @package core\modules\admin\modules\rbac\controllers
 */
class RuleController extends Controller
{
    /**
     * @var string search class name for rules search
     */
    public $searchClass = [
        'class' => BizRuleSearch::class,
    ];

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
        return ArrayHelper::merge($behaviors, parent::behaviors());
    }

    /**
     * List of all rules
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Rule item.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new Rule item.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BizRuleModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Rule has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Rule item.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Rule has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Rule item.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->authManager->remove($model->item);
        Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Rule has been deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the BizRuleModel based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return BizRuleModel the loaded model
     *
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findModel($id)
    {
        $item = Yii::$app->authManager->getRule($id);
        if ($item) {
            return new BizRuleModel($item);
        } else {
            throw new NotFoundHttpException(Yii::t('AdminModule.rbac_base', 'The requested page does not exist.'));
        }
    }
}
