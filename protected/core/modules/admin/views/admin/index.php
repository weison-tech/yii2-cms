<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\modules\admin\models\Admin;

/* @var $this yii\web\View */
/* @var $searchModel core\modules\admin\models\search\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('AdminModule.widgets_AdminMenu', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-body table-responsive no-padding">

    <div class="navbar navbar-default">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>

    <p>
        <?= Html::a(Yii::t('AdminModule.base', 'Create Admin'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'headerRowOptions' => ['class' => 'text-center'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
             'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Admin::$stat[$model->status];
                },
                'filter' => Admin::$stat,
            ],
            [
                'attribute' => 'created_at',
                'content' => function ($model) {
                    return date("Y-m-d H:i:s", $model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'content' => function ($model) {
                    return date("Y-m-d H:i:s", $model->updated_at);
                },
            ],
            [
                'class' => 'core\modules\admin\widgets\ActionColumn',
                'options' => ['style' => 'width:240px;'],
            ],
        ],
    ]); ?>
</div>
