<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \core\modules\admin\modules\rbac\models\search\AuthItemSearch */

$labels = $this->context->getLabels();
$this->title = Yii::t('AdminModule.rbac_base', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="item-index">
    <p>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('AdminModule.rbac_base', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('AdminModule.rbac_base', 'Rule Name'),
                'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('AdminModule.rbac_base', 'Select Rule')],
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => Yii::t('AdminModule.rbac_base', 'Description'),
            ],

            [
                'label' => Yii::t('base', 'Operation'),
                'format' => 'raw',
                'value' => function ($data) {
                    $viewUrl = Url::to(['view', 'id' => $data->name]);
                    $updateUrl = Url::to(['update', 'id' => $data->name]);
                    $deleteUrl = Url::to(['delete', 'id' => $data->name]);
                    return "<div class='btn-group'>" .
                        Html::a(Yii::t('AdminModule.rbac_base', 'View'), $viewUrl,
                            ['title' => Yii::t('AdminModule.rbac_base', 'View'), 'class' => 'btn btn-sm btn-info']) .
                        Html::a(Yii::t('AdminModule.rbac_base', 'Update'), $updateUrl,
                            ['title' => Yii::t('AdminModule.rbac_base', 'Update'), 'class' => 'btn btn-sm btn-primary']) .
                        Html::a(Yii::t('AdminModule.rbac_base', 'Delete'), $deleteUrl, [
                            'title' => Yii::t('AdminModule.rbac_base', 'Delete'),
                            'class' => 'btn btn-sm btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('base', 'Are you sure you want to delete this item?')
                        ]) .
                        "</div>";
                },
                'options' => ['style' => 'width:200px;'],
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>