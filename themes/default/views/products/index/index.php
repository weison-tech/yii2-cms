<?php
use yii\helpers\Url;

$this->pageTitle = '案例';
?>

<section class="container" style="padding:0;">
    <div class="row wow fadeInUp" id="portfolio_nav" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="col-sm-12">
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?= !isset($_GET['id']) ? 'active' : '' ?>"><a href="<?= Url::to(['/products']) ?>">全部</a></li>
                    <?php if ($cate) { foreach ($cate as $c) { ?>
                        <li class="<?= isset($_GET['id']) && $_GET['id'] == $c->id ? 'active' : '' ?>"><a href="<?= Url::to(['/products', 'id' => $c->id]) ?>"><?= $c->name ?></a></li>
                    <?php } } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="portfolio" class="portfolio_pad">
    <div class="container-fluid call">
        <div class="row">
            <?php if ($model) { $delay = 300; foreach ($model as $item) { ?>

                <div class="col-sm-4 col-xs-6">
                    <div class="folio-item wow fadeInRightBig" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <div class="folio-image">
                            <img class="img-responsive" src="<?= $item->img ? $item->img->getOriginImageUrl() : ''?>" alt="">
                        </div>
                        <div class="overlay">
                            <div class="overlay-content">
                                <div class="overlay-text">
                                    <div class="folio-info">
                                        <h3><?= $item->name ?></h3>
                                        <p><?= $item->title ?></p>
                                    </div>
                                    <div class="folio-overview">
                                        <span class="folio-link"><a class="folio-read-more" href="<?= Url::to(['/product_detail/'. $item->id]) ?>" ><i class="fa fa-link"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="wow fadeInRightBig name_sty" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms"><?= $item->name ?></p>
                </div>

            <?php $delay++; } } ?>

        </div>
    </div>
</section>
<section style="padding: 0">
    <div class="row pag wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="col-sm-12 text-center pagination">
            <ul class="list-unstyled">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'options' => ['css' => 'list-unstyled']
                ]); ?>
            </ul>
        </div>
    </div>
</section>
<div class="container" id="footer_nav">
    <div class="row xs_footer_nav">
        <div class="dropup">
            <div class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $current_cat ?> <i class="fa fa-caret-up"></i></div>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" style="">
                <li><a href="<?= Url::to(['/products']) ?>">全部</a></li>
                <?php if ($cate) { foreach ($cate as $c) { ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?= Url::to(['/products', 'id' => $c->id]) ?>"><?= $c->name ?></a></li>
                <?php } } ?>
            </ul>
        </div>
    </div>
</div>