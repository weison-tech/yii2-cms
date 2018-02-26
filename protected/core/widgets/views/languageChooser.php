<?php
use yii\widgets\ActiveForm;
?>
<div class="text-center">
    <?php if (count($languages) > 1) : ?>
        <?php $form = ActiveForm::begin([
            'id' => 'choose-language-form',
            'options' => ['class' => 'form-inline']
        ]); ?>

        <?= $form->field($model, 'language')
            ->dropDownList($languages,['onChange' => 'this.form.submit()'])
        ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>