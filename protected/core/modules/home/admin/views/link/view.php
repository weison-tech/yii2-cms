<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Link */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('HomeModule.base', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-view">

    <p>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('base', 'Back to list'), ['index'], ['class' => 'btn btn-info btn-flat']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'sort_order',
            [
                'attribute'=>'thumb',
                'value'=>$model->img ? $model->img->getPreviewImageUrl(15, 15) : '-',
                'format' => $model->img ? ['image',['width'=>'15','height'=>'15']] : 'raw',
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
