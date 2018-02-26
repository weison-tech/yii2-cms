<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use core\models\Category;

/* @var $this yii\web\View */
/* @var $model core\modules\products\models\search\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

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

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(
            Category::get(
                0,
                Category::find()->where(['status'=>Category::STATUS_ENABLED, 'type' => Category::TYPE_PRODUCT])->asArray()->all()
            ), 'id', 'label'
        ),
        ['class' => 'form-control', 'prompt' => Yii::t('base', 'Please Filter')]
    ) ?>

    <?= $form->field($model, 'industry_id')->dropDownList(
        ArrayHelper::map(
            Category::get(
                0,
                Category::find()->where(['status'=>Category::STATUS_ENABLED, 'type' => Category::TYPE_INDUSTRY])->asArray()->all()
            ), 'id', 'label'
        ),
        ['class' => 'form-control', 'prompt' => Yii::t('base', 'Please Filter')]
    ) ?>

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
