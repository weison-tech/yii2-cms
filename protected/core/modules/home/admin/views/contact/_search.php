<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\search\CantactSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'contact-form',
        'options' => [
            'class' => 'form-inline',
            'style' => 'margin: 0 10px;',
        ],
        'fieldConfig' => [
            'template' => "{label}: {input}",
            'inputOptions' => [
                'class' => 'form-control',
                'style' => 'margin:10px 0;',
            ],
        ]
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'company') ?>

    <?= $form->field($model, 'mobile') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'demand') ?>

    <input name="export" type="hidden" id="export" value="0" />

    <?= $form->field($model, 'status')->dropDownList(
        $model::getStatus(),
        ['class' => 'form-control', 'prompt' => Yii::t('base', 'Please Filter')]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-primary btn-flat', 'onclick' => "javascript:$('#export').val(0); $('#contact-form').submit();"]) ?>
        <?= Html::submitButton(Yii::t('base', 'Export'), ['class' => 'btn btn-info btn-flat', 'onclick' => "javascript:$('#export').val(1); $('#contact-form').submit();"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
