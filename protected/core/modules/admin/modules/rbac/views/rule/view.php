<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('AdminModule.rbac_base', 'Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->render('/layouts/_sidebar');
?>
<div class="rule-item-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('AdminModule.rbac_base', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]); ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'className',
        ],
    ]); ?>

</div>
