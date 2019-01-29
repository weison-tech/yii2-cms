<?php
use yii\helpers\Url;

$this->pageTitle = '案例详情';
?>

<div class="secede"><a href="<?= Url::to(['/products']) ?>"><i class="glyphicon glyphicon-menu-left"></i>  返回</a></div>
<section class="container" id="portfolio_minute">
    <div class="row">
        <div class="col-sm-9 col-xs-12 up_box">
            <div id="bi" class="heading text-center wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h1><?= $model->name ?></h1>
                <h2><?= $model->category ? $model->category->name : '' ?></h2>
                <h2><?= $model->industry ? $model->industry->name : '' ?></h2>
            </div>
            <div class="post-thumb">
                <div id="post-carousel"  class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php if ($model->album) { foreach ($model->album as $k => $v) { ?>
                            <li data-target="#post-carousel" data-slide-to="<?= $k ?>" class="<?= $k == 0 ? 'active' : '' ?>"></li>
                        <?php } ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php if ($model->album) { foreach ($model->album as $k => $v) { ?>
                            <div class="item <?= $k == 0 ? 'active' : '' ?>">
                                <a href="#"><img class="img-responsive" src="<?= $v->getOriginImageUrl() ?>" alt=""></a>
                            </div>
                        <?php } } ?>
                    </div>
                    <a class="blog-left-control" href="#post-carousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    <a class="blog-right-control" href="#post-carousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12 down_box">
            <div class="media">
                <div class="media-body">
                    <div class="midia-heading">
                        <i>项目名称：</i><span><?= $model->name ?></span>
                    </div>
                    <div class="midia-heading">
                        <i>服务分类：</i><span><?= $model->category ? $model->category->name : '' ?></span>
                    </div>
                    <div class="midia-heading">
                        <i>行业分类：</i><span><?= $model->industry ? $model->industry->name : '' ?></span>
                    </div>
                </div>
                <div class="media_footer">
                    <?= $model->description ?>
                </div>
            </div>
        </div>
    </div>
</section>