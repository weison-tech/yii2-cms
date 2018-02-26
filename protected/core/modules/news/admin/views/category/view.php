<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('NewsModule.base', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

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
            [
                'attribute'=>'parent_id',
                'value'=> $model->parent ? $model->parent->name : '-',
                'format' => 'raw',
            ],
            'sort_order',
            [
                'attribute'=>'thumb',
                'value'=>$model->img ? $model->img->getPreviewImageUrl(200, 200) : '-',
                'format' => $model->img ? ['image',['width'=>'100','height'=>'100']] : 'raw',
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
