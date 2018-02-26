<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\search\BannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => [
            'class' => 'form-inline',
            'style' => 'margin:10px;',
        ],
        'fieldConfig' => [
            'template' => "{label}: {input}",
            'inputOptions' => [
                'class' => 'form-control',
                'style' => 'margin-right:8px;',
            ],
        ]
    ]); ?>


    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'status')->dropDownList(
        $model::getStatus(),
        ['class' => 'form-control', 'prompt' => Yii::t('base', 'Please Filter')]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
