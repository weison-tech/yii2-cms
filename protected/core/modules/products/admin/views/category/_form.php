<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model core\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(
            $model::get(
                0,
                $model::find()->where(['status'=>$model::STATUS_ENABLED, 'type' => $model::TYPE_PRODUCT])->asArray()->all()
            ), 'id', 'label'
        ),
        ['class' => 'form-control', 'prompt' => Yii::t('base', 'Please Filter')]
    ) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'thumb')->widget('core\modules\file\widgets\Upload',
        [
            'url' => ['/file/file/upload'],
            'maxFileSize' => 10 * 1024 * 1024, // 10 MiB,
            'minFileSize' => 1,
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]
    ); ?>

    <?= $form->field($model, 'status')->dropDownList($model::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
