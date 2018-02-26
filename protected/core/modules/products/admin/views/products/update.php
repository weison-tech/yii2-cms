<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\modules\products\models\Products */

$this->title = Yii::t('ProductsModule.base', 'Update Products: ', [
    'modelClass' => 'Products',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ProductsModule.base', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base', 'Update');
?>
<div class="products-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
