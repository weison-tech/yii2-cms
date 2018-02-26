<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\modules\products\models\Products */

$this->title = Yii::t('ProductsModule.base', 'Create Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ProductsModule.base', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
