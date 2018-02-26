<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\AuthItemModel */

$context = $this->context;
$labels = $this->context->getLabels();
$this->title = Yii::t('AdminModule.rbac_base', 'Update ' . $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('AdminModule.rbac_base', 'Update');
$this->render('/layouts/_sidebar');
?>
<div class="auth-item-update">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>