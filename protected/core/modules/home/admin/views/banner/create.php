<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Banner */

$this->title = Yii::t('HomeModule.base', 'Create Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Banner Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
