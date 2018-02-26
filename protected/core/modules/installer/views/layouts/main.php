<?php

use yii\helpers\Html;
use core\modules\installer\assets\InstallerAsset;

/* @var $this \yii\web\View */
/* @var $content string */

InstallerAsset::register($this); ?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title><?php echo Html::encode($this->title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="language" content="en"/>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>
    <div class="container installer" style="margin: 0 auto; max-width: 770px;">
        <div class="logo">
            <a href="/" target="_blank">
                <img src="<?php echo Yii::getAlias("@web-static/img/"); ?>/logo.png" alt="Logo">
            </a>
        </div>

        <?php echo $content; ?>

        <div class="text text-center powered">
            Powered by <a href="https://github.com/weison-tech" target="_blank">weison-tech</a>
            <br/>
            <br/>
        </div>
    </div>
    <div class="clear"></div>
    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>