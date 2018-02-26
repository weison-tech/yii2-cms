<?php
use yii\helpers\Url;
?>

<!--导航-->
<div class="main-nav">

    <div class="container wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="toggle_cls" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="close">X</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-logo"><img src="<?= $logo_url ?>" alt="logo"></a>
        </div>
        <div class="collapse navbar-collapse">
            <?php
                $action = Yii::$app->request->pathInfo;
            ?>
            <ul class="nav navbar-nav">
                <li class="scroll <?= $action == '' ? 'active' : '' ?>"><a href="/">首页</a></li>
                <li class="scroll <?= $action == 'products.html' || (strpos($action, 'product_detail/') === 0) || (strpos($action, 'products/index/index.html') === 0) ? 'active' : '' ?>"><a href="<?= Url::to(['/products']) ?>">案例</a></li>
                <li class="scroll <?= $action == 'services.html' ? 'active' : '' ?>"><a href="<?= Url::to(['/home/index/services']) ?>">服务</a></li>
                <li class="navbar-width">&nbsp;</li>
                <li class="scroll <?= $action == 'about.html' ? 'active' : '' ?>"><a href="<?= Url::to(['/home/index/about']) ?>">关于</a></li>
                <li class="scroll <?= $action == 'news.html' || (strpos($action, 'news_detail/') === 0) || (strpos($action, 'news/index/index.html') === 0) ? 'active' : '' ?>"><a href="<?= Url::to(['/news']) ?>">动态</a></li>
                <li class="scroll <?= $action == 'contact.html' ? 'active' : '' ?>"><a href="<?= Url::to(['/home/index/contact']) ?>">联系</a></li>
            </ul>
        </div>
    </div>

</div>
<!--导航-->