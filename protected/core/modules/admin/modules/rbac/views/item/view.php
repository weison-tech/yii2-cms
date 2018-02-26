<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;
use core\modules\admin\modules\rbac\RbacAsset;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->title = Yii::t('AdminModule.rbac_base', $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->render('/layouts/_sidebar');
?>
<div class="auth-item-view">
    <p>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('AdminModule.rbac_base', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]); ?>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Create'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
            ]); ?>
        </div>
    </div>
    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
            'label' => [
                'label_roles' => Yii::t('AdminModule.rbac_base', 'Roles'),
                'label_permission' => Yii::t('AdminModule.rbac_base', 'Permissions'),
                'label_routes' => Yii::t('AdminModule.rbac_base', 'Routes'),
            ],
        ]),
        'assignUrl' => ['assign', 'id' => $model->name],
        'removeUrl' => ['remove', 'id' => $model->name],
    ]); ?>
</div>
