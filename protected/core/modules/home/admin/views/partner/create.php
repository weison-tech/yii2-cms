<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Partner */

$this->title = Yii::t('HomeModule.base', 'Create Partner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
