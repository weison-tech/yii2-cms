<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\models\Category */

$this->title = Yii::t('ProductsModule.base', 'Update Category: ', [
    'modelClass' => 'Category',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ProductsModule.base', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
