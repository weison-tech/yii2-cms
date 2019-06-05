<?php

use core\libs\TimezoneHelper;
use  yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('AdminModule.base', 'Basic Setting');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timeZone')->dropDownList(TimezoneHelper::generateList(true)); ?>

    <?= $form->field($model, 'theme')->dropDownList($model->getThemes()); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Update'), ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>