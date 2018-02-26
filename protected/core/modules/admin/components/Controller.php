<?php

namespace core\modules\admin\components;

use Yii;
use yii\filters\VerbFilter;
use core\modules\admin\modules\rbac\filters\AccessControl;

/**
 * Base controller for administration section
 */
class Controller extends \yii\web\Controller
{
    public $layout = "@core/modules/admin/views/layouts/main";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                //When application in product environment, this line should be deleted.
                'allowActions' => Yii::$app->params['notCheckPermissionAction'],
                'user' => 'admin',
            ],

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}
