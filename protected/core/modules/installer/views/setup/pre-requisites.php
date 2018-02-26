<?php
use yii\helpers\Html;
use core\modules\installer\widgets\PreRequisitesList;
?>

<div class="panel panel-default">

    <div class="panel-heading">
        <?php echo Yii::t('InstallerModule.views_setup_pre-requisites', '<strong>System</strong> Check'); ?>
    </div>

    <div class="panel-body">
        <p><?php echo Yii::t('InstallerModule.views_setup_pre-requisites', 'This overview shows all system requirements of Yii2-cms.'); ?></p>

        <hr/>
        <?= PrerequisitesList::widget(); ?>
        
        <?php if (!$hasError): ?>
            <div class="alert alert-success">
                <?php echo Yii::t('InstallerModule.views_setup_pre-requisites', 'Congratulations! Everything is ok and ready to start over!'); ?>
            </div>
        <?php endif; ?>

        <hr>

        <?php echo Html::a('<i class="fa fa-repeat"></i> ' . Yii::t('InstallerModule.views_setup_pre-requisites', 'Check again'), array('/installer/setup/pre-requisites'), array('class' => 'btn btn-default', 'data-ui-loader' => '')); ?>

        <?php if (!$hasError): ?>
            <?php echo Html::a(Yii::t('InstallerModule.base', 'Next') . ' <i class="fa fa-arrow-circle-right"></i>', array('/installer/setup/database'), array('class' => 'btn btn-primary', 'data-ui-loader' => '')); ?>
        <?php endif; ?>

    </div>
</div>