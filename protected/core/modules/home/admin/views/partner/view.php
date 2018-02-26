<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Partner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-view">

    <p>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'sort_order',
            'url:url',
            [
                'attribute'=>'thumb',
                'value'=>$model->img ? $model->img->getPreviewImageUrl(170, 88) : '-',
                'format' => $model->img ? ['image',['width'=>'170','height'=>'88']] : 'raw',
            ],
            [
                'attribute'=>'status',
                'value'=> $model::getStatus($model->status),
                'format' => 'raw',
            ],
            'created_at:datetime',
            [
                'attribute'=>'created_by',
                'value'=> $model->creator ? $model->creator->username : '-',
                'format' => 'raw',
            ],
            'updated_at:datetime',
            [
                'attribute'=>'updated_by',
                'value'=> $model->reviser ? $model->reviser->username : '-',
                'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
