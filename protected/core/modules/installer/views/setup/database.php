<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div id="database-form" class="panel panel-default">
    <div class="panel-heading">
        <?php echo Yii::t('InstallerModule.views_setup_database', '<strong>Database</strong> Configuration'); ?>
    </div>

    <div class="panel-body">
        <p>
            <?php echo Yii::t('InstallerModule.views_setup_database', 'Below you have to enter your database connection details. If you’re not sure about these, please contact your system administrator.'); ?>
        </p>

        <?php $form = ActiveForm::begin(); ?>

        <hr/>

        <?= $form->field($model, 'hostname')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'database')->textInput() ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger">
                <strong><?php echo Yii::t('InstallerModule.views_setup_database', 'Ohh, something went wrong!'); ?></strong><br/>
                <?php echo Html::encode($errorMessage); ?>
            </div>
        <?php } ?>

        <hr>

        <?php echo Html::submitButton(Yii::t('InstallerModule.base', 'Next') . ' <i class="fa fa-arrow-circle-right"></i>', array('class' => 'btn btn-primary', 'data-loader' => "modal", 'data-message' => Yii::t('InstallerModule.views_setup_database', 'Initializing database...'))); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
