<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\modules\admin\modules\rbac\models\BizRuleModel */
/* @var $form ActiveForm */
?>

<div class="rule-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>

    <?php echo $form->field($model, 'className')->textInput(); ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->getIsNewRecord() ? Yii::t('AdminModule.rbac_base', 'Create') : Yii::t('AdminModule.rbac_base', 'Update'),
            [
                'class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary',
            ]
        ); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
