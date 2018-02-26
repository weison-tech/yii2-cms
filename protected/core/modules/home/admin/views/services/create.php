<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\Category */

$this->title = Yii::t('HomeModule.base', 'Create Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
