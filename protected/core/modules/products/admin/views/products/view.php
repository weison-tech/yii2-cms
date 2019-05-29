<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\products\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('ProductsModule.base', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

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
            [
                'attribute'=>'thumb',
                'value'=>$model->img ? $model->img->getPreviewImageUrl(200, 200) : '-',
                'format' => $model->img ? ['image',['width'=>'100','height'=>'100']] : 'raw',
            ],
            [
                'attribute'=>'category_id',
                'value'=> $model->category ? $model->category->name : '-',
                'format' => 'raw',
            ],
            [
                'attribute'=>'industry_id',
                'value'=> $model->industry ? $model->industry->name : '-',
                'format' => 'raw',
            ],
            'name',
            'title',
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
            [
                'attribute'=>'images',
                'value'=> function($model) {
                    $html = '';
                    foreach ($model->album as $img) {
                        $html .= '<img src="' . $img->getPreviewImageUrl(200, 100) .'" style="padding:10px;" />';
                    }
                    return $html;
                },
                'format' => 'raw',
            ],
            'description:html',
        ],
    ]) ?>

</div>
