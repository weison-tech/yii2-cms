<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Link */

$this->title = Yii::t('HomeModule.base', 'Create Link');
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
