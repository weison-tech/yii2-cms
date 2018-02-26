<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('AdminModule.rbac_base', 'Update Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('AdminModule.rbac_base', 'Update');
$this->render('/layouts/_sidebar');
?>
<div class="rule-item-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>