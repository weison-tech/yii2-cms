<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel core\modules\admin\modules\rbac\models\search\BizRuleSearch */

$this->title = Yii::t('AdminModule.rbac_base', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="role-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Create Rule'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php Pjax::begin(['timeout' => 5000]); ?>

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
                'header' => Yii::t('AdminModule.rbac_base', 'Action'),
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>
