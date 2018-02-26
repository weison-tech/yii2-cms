<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div id="create-admin-account-form" class="panel panel-default">

    <div class="panel-heading">
        <?php echo Yii::t('InstallerModule.views_config_admin', '<strong>Admin</strong> Account'); ?>
    </div>

    <div class="panel-body">

        <p><?php echo Yii::t('InstallerModule.views_config_admin', "You're almost done. In this step you have to fill out the form to create an admin account. With this account you can manage the whole network."); ?></p>

        <hr/>

        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'password_hash')->passwordInput() ?>

        <?php echo Html::submitButton(Yii::t('InstallerModule.base', 'Next') . ' <i class="fa fa-arrow-circle-right"></i>', array('class' => 'btn btn-primary', 'data-ui-loader' => '')); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
