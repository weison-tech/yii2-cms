<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\modules\admin\modules\rbac\models\AuthItemModel */
?>
<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 2]); ?>

    <?php echo $form->field($model, 'ruleName')->widget('yii\jui\AutoComplete', [
        'options' => [
            'class' => 'form-control',
        ],
        'clientOptions' => [
            'source' => array_keys(Yii::$app->authManager->getRules()),
        ],
    ]);
    ?>

    <?php echo $form->field($model, 'data')->textarea(['rows' => 6]); ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->getIsNewRecord() ? Yii::t('AdminModule.rbac_base', 'Create') : Yii::t('AdminModule.rbac_base', 'Update'), ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
