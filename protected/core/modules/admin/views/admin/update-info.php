<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model core\modules\admin\models\Admin */

$this->title = Yii::t('AdminModule.base', 'Update Info');
$this->params['breadcrumbs'][] = Yii::t('AdminModule.base', 'Update Info');
?>

<div class="admin-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => true]) ?>

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
