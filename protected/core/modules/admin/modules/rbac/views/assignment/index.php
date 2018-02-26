<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $gridViewColumns array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \core\modules\admin\modules\rbac\models\search\AssignmentSearch */

$this->title = Yii::t('AdminModule.rbac_base', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="assignment-index">

    <?php Pjax::begin(['timeout' => 5000]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => ArrayHelper::merge($gridViewColumns, [
            [
                'label' => Yii::t('base', 'Operation'),
                'format' => 'raw',
                'value' => function ($data) {
                    $viewUrl = Url::to(['view', 'id' => $data->id]);
                    return Html::a(Yii::t('AdminModule.rbac_base', 'Assignment'), $viewUrl,
                            ['title' => Yii::t('AdminModule.rbac_base', 'Assignment'), 'class' => 'btn btn-sm btn-info']);
                },
                'options' => ['style' => 'width:200px;'],
            ]
        ]),
    ]); ?>

    <?php Pjax::end(); ?>
</div>
