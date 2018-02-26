<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="panel panel-default">

    <div class="panel-body text-center">

        <br><br>

        <p class="lead">
            <?php echo Yii::t('InstallerModule.views_index_index',
                '<strong>Welcome</strong> use Yii2-cms<br> to create your own enterprise site.'
            ); ?>
        </p>

        <p>
            <?php
                echo Yii::t('InstallerModule.views_index_index',
                'This wizard will install and configure your own platform instance.<br><br>To continue, click Next.');
            ?>
        </p>

        <br><hr><br>

        <?php echo Html::a(
                Yii::t('InstallerModule.base', "Next")
                . ' <i class="fa fa-arrow-circle-right"></i>',
                Url::to(['go']),
            array('class' => 'btn btn-primary')); ?>
        <br><br>
    </div>

</div>

<?php echo core\widgets\LanguageChooser::widget(); ?>
