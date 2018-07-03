<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\modules\admin\models\Admin */

$this->title = Yii::t('AdminModule.base', 'Create Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
