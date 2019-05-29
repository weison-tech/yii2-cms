<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Banner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Banner Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">

    <p>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger  btn-flat',
            'data' => [
                'confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('base', 'Back to list'), ['index'], ['class' => 'btn btn-info  btn-flat']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'title',
            [
                'attribute'=>'thumb',
                'value'=>$model->img ? $model->img->getPreviewImageUrl(218, 130) : '-',
                'format' => $model->img ? ['image',['width'=>'218','height'=>'130']] : 'raw',
            ],
            'url:url',
            'sort_order',
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
