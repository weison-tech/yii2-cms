<?php

use yii\helpers\Html;
use yii\helpers\Json;
use core\modules\admin\modules\rbac\RbacAsset;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\AssignmentModel */
/* @var $usernameField string */

$userName = $model->user->{$usernameField};
$this->title = Yii::t('AdminModule.rbac_base', 'Assignment : {0}', $userName);
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $userName;
$this->render('/layouts/_sidebar');
?>
<div class="assignment-index">

    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
            'label' => [
                'label_roles' => Yii::t('AdminModule.rbac_base', 'Roles'),
                'label_permission' => Yii::t('AdminModule.rbac_base', 'Permissions'),
                'label_routes' => Yii::t('AdminModule.rbac_base', 'Routes'),
            ],
        ]),
        'assignUrl' => ['assign', 'id' => $model->userId],
        'removeUrl' => ['remove', 'id' => $model->userId],
    ]); ?>

</div>
