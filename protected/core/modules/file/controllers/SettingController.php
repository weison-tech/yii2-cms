<?php
namespace core\modules\file\controllers;

use Yii;
use yii\filters\AccessControl;
use core\modules\admin\components\Controller;
use core\modules\file\models\FileSetting;

/**
 * Class FileController
 * @package core\modules\file\controllers
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class SettingController extends Controller
{

    /**
     * Setting
     */
    public function actionIndex()
    {
        $model = new FileSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('FileModule.controllers_FileController', 'Setting successfully.')
            );
        }

        return $this->render('index', ['model' => $model]);
    }
}
