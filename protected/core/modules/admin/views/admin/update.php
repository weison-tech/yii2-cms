<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\modules\admin\models\Admin */

$this->title = Yii::t('AdminModule.base', 'Update Admin:') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="admin-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
