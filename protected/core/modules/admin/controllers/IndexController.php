<?php
namespace core\modules\admin\controllers;

use Yii;
use core\modules\admin\components\Controller;
use core\modules\admin\forms\LoginForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class IndexController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'user' => 'admin',
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

        return ArrayHelper::merge($behaviors, parent::behaviors());
    }

    /**
     * Home Index
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * User login
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';
        if (!Yii::$app->admin->isGuest) {
            return $this->redirect(['index']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $returnUrl = Yii::$app->admin->returnUrl;
            if ($returnUrl == '/index.php') {
                $returnUrl = Url::to(['index']);
            }
            return $this->redirect($returnUrl);
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    /**
     * User logout
     */
    public function actionLogout()
    {
        Yii::$app->admin->logout();
        return $this->redirect(['login']);
    }

    /**
     * Ajax setting
     */
    public function actionAjaxLayoutSetting()
    {
        $params = Yii::$app->request->post();
        if (isset($params['name']) && isset($params['value'])) {
            $this->module->settings->set($params['name'], $params['value']);
        }
    }

    /**
     * Set language
     */
    public function actionSetLanguage()
    {
        return $this->render('set-language');
    }
}
