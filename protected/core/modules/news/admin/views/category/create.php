<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\Category */

$this->title = Yii::t('NewsModule.base', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('NewsModule.base', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
