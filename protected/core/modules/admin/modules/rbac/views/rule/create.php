<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('AdminModule.rbac_base', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('AdminModule.rbac_base', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="rule-item-create">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>