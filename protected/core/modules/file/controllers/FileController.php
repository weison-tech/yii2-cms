<?php
namespace core\modules\file\controllers;

use Yii;
use yii\web\HttpException;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use core\components\Controller;
use core\modules\file\models\File;

/**
 * Class FileController
 * @package core\modules\file\controllers
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class FileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'user' => 'admin',
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['download'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'core\modules\file\actions\UploadAction',
            ],
            'upload-simple' => [
                'class' => 'core\modules\file\actions\UploadSimpleAction',
            ],
        ];
    }


    /**
     * Delete file.
     * @throws HttpException
     */
    public function actionDelete()
    {
        $guid = Yii::$app->request->post('guid');
        $file = File::findOne(['guid' => $guid]);

        if ($file == null) {
            throw new HttpException(
                404,
                Yii::t(
                    'FileModule.controllers_FileController',
                    'Could not find requested file!'
                )
            );
        }

        $file->delete();
    }
}
