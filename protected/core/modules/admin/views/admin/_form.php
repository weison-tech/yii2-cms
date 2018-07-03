<?php

use core\modules\admin\models\Admin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model core\modules\admin\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(Admin::$stat) ?>

        <?= $form->field($model, 'avatar')->widget('core\modules\file\widgets\Upload',
            [
                'url' => ['/file/file/upload'],
                'maxFileSize' => 10 * 1024 * 1024, // 10 MiB,
                'minFileSize' => 1,
                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
            ]
        ); ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
