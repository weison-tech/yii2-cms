<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Banner */

$this->title = Yii::t('HomeModule.base', 'Update Banner: ', [
    'modelClass' => 'Banner',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Banner Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
