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

    <div class="navbar navbar-default">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <p>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success btn-flat']); ?>
    </p>
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('AdminModule.rbac_base', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('AdminModule.rbac_base', 'Rule Name'),
                //'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                //'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('AdminModule.rbac_base', 'Select Rule')],
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => Yii::t('AdminModule.rbac_base', 'Description'),
            ],

            [
                'class' => 'core\modules\admin\widgets\ActionColumn',
                'options' => ['style' => 'width:240px;'],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>