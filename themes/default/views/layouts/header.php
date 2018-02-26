<?php
use core\modules\home\widgets\HomeNav;
use core\modules\home\widgets\HomeBanner;
?>

<header id="home">


    <!--导航 start-->
    <?= HomeNav::widget() ?>
    <!--导航 end-->

    <?php if (Yii::$app->request->pathInfo == '') { ?>
        <!-- 首页轮播图 start-->
        <?= HomeBanner::widget() ?>
        <!-- 首页轮播图 end-->
    <?php } ?>

</header><!--/#home-->