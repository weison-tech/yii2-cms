<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use core\modules\home\assets\HomeAsset;

HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->pageTitle ? Html::encode($this->pageTitle) : '' ?></title>
    <link id="css-preset" href="/themes/default/css/presets/preset1.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/themes/default/js/html5shiv.js"></script>
    <script src="/themes/default/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/themes/default/images/favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php
        $path = Yii::$app->request->pathInfo;
        switch ($path) {
            case 'about.html':
                $id_str = "about_mb";
                break;
            case 'contact.html':
                $id_str = "contact_way";
                break;
            case 'news.html':
                $id_str = "news";
                break;
            default:
                $id_str = "";
        }

        if ($id_str == "") {
            if(strpos($path, "news_detail/") === 0) {
                $id_str = "news";
            }
        }
    ?>

    <div class="centent" <?= $id_str ? 'id = "' . $id_str . '"' : '' ?>>


        <?php
            $action = $this->context->module->id . '/' . $this->context->id . '/' . $this->context->action->id;
            if ($action == 'home/index/index') {
        ?>
            <!--.加载-->
            <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
            <!--/.加载-->
        <?php } ?>

        <?= $this->render('header') ?>

        <?= $content ?>

        <?= $this->render('footer') ?>

    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
