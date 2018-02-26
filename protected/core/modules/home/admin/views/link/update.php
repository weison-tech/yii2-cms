<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Link */

$this->title = Yii::t('HomeModule.base', 'Update Link: ', [
    'modelClass' => 'Link',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('HomeModule.base', 'Update');
?>
<div class="link-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
