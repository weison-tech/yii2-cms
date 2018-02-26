<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel panel-default animated fadeIn">

    <div class="panel-body text-center">
        <br>
        <p class="lead"><?= Yii::t('InstallerModule.views_config_finished', "<strong>Congratulations</strong>. You're done."); ?></p>

        <p><?= Yii::t('InstallerModule.views_config_finished', "The installation completed successfully! Have fun with your new platform."); ?></p>

        <div class="text-center">
            <br>
            <?= Html::a(Yii::t('InstallerModule.views_config_finished', 'View frontend'), Url::home(), ['class' => 'btn btn-primary', 'data-ui-loader' => '', 'data-pjax-prevent' => '']); ?>
            <?= Html::a(Yii::t('InstallerModule.views_config_finished', 'Go to admin panel'), Url::to(['/admin/index/login']), ['class' => 'btn btn-info', 'data-ui-loader' => '', 'data-pjax-prevent' => '']); ?>
            <br><br>
        </div>
    </div>
</div>
