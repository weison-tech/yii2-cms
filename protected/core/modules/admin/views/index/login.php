<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('AdminModule.views_index_login', 'Sign In');

?>
<div class="login-box">
    <div class="login-logo">
        <?php echo Yii::t('AdminModule.views_index_login', 'Sign In') ?>
    </div><!-- /.login-logo -->
    <div class="header"></div>
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="body">
            <?php echo $form->field($model, 'username') ?>
            <?php echo $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'captcha')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-7">{input}</div><div class="col-lg-4">{image}</div></div>',
                'options' => [
                    "class" => "form-control",
                ],
                'captchaAction' => '/admin/index/captcha',
                'imageOptions' => [
                    "style" => "cursor:pointer;right:0px"
                ],
            ]) ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'simple']) ?>
        </div>
        <div class="footer">
            <?php echo Html::submitButton(Yii::t('AdminModule.views_index_login', 'Sign me in'), [
                'class' => 'btn btn-primary btn-flat btn-block',
                'name' => 'login-button'
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>