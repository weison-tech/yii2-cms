<?php

namespace core\modules\admin\modules\rbac\base;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use core\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use core\modules\admin\modules\rbac\models\AuthItemModel;
use core\modules\admin\modules\rbac\models\search\AuthItemSearch;

/**
 * Class ItemController
 *
 * @package core\modules\admin\modules\rbac\base
 */
class ItemController extends Controller
{
    /**
     * @var string search class name for auth items search
     */
    public $searchClass = [
        'class' => AuthItemSearch::class,
    ];

    /**
     * @var int Type of Auth Item
     */
    protected $type;

    /**
     * @var array labels use in view
     */
    protected $labels;

    /**
     * @inheritdoc
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
                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];

        return ArrayHelper::merge($behaviors, parent::behaviors());
    }

    /**
     * Lists of all auth items
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $searchModel->type = $this->type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param  string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemModel();
        $model->type = $this->type;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Item has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing AuthItem model.
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
            Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Item has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing AuthItem model.
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
        Yii::$app->getAuthManager()->remove($model->item);
        Yii::$app->session->setFlash('success', Yii::t('AdminModule.rbac_base', 'Item has been removed.'));

        return $this->redirect(['index']);
    }

    /**
     * Assign items
     *
     * @param string $id
     *
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->addChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * Remove items
     *
     * @param string $id
     *
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->removeChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'item';
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return AuthItemModel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $auth = Yii::$app->getAuthManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);

        if ($item) {
            return new AuthItemModel($item);
        } else {
            throw new NotFoundHttpException(Yii::t('AdminModule.rbac_base', 'The requested page does not exist.'));
        }
    }
}
