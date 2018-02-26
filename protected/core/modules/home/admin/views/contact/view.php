<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Contact */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-view">

    <p>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('base', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'company',
            'mobile',
            'email:email',
            'demand:ntext',
            'created_at:datetime',
            [
                'attribute'=>'status',
                'value'=> $model::getStatus($model->status),
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
