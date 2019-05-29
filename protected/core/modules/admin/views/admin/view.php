<?php

use core\modules\admin\models\Admin;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\modules\admin\models\Admin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-header">
    <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger btn-flat',
        'data' => [
            'confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
    <?= Html::a(Yii::t('base', 'Back To List'), ['index'], ['class' => 'btn btn-info btn-flat']) ?>
</div>
<div class="box-body table-responsive no-padding">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'attribute'=>'status',
                    'value'=> Admin::$stat[$model->status],
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'value' => date("Y-m-d H:i:s", $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => date("Y-m-d H:i:s", $model->updated_at),
            ],
            [
                'attribute'=>'avatar',
                'value'=>$model->avatarImg ? $model->avatarImg->getPreviewImageUrl(100, 100) : '-',
                'format' => $model->avatarImg ? ['image',['width'=>'100','height'=>'100']] : 'raw',
            ],
        ],
    ]) ?>
</div>
