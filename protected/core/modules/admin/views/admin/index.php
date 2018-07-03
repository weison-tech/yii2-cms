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
<div class="admin-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('AdminModule.base', 'Create Admin'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

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
                 'created_at:datetime',
                 'updated_at:datetime',
                ['class' => 'core\modules\admin\widgets\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
