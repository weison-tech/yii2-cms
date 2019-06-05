<?php
/**
 * @var array $languages
 */
use yii\widgets\ActiveForm;
?>

<?php if (count($languages) > 1) : ?>

    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-language"></i>
        </a>
        <ul class="dropdown-menu" style="width: 100px;margin-top: 2px;">
            <li>
                <div>
                    <ul class="menu">
                        <?php foreach ($languages as $short => $language) { ?>
                            <li class="text-center">
                                <a href='javascript:$("#language-chooser").val("<?= $short ?>"); $("#choose-language-form").submit();'>
                                    <?= $language ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
        </ul>
    </li>

    <?php $form = ActiveForm::begin([
        'id' => 'choose-language-form',
        'options' => [
            'style' => 'display:none;',
        ],
    ]); ?>
        <input type="hidden" name="ChooseLanguage[language]" id="language-chooser" />
    <?php ActiveForm::end(); ?>

<?php endif; ?>