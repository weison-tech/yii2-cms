<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Partner */

$this->title = Yii::t('HomeModule.base', 'Update Partner: ', [
    'modelClass' => 'Partner',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="partner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
