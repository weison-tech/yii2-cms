<?php
use yii\helpers\Url;

$this->pageTitle = '首页';
?>
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h1>彰显气质与提升价值</h1>
                <h2>经典案例</h2>
                <p>致力于用设计提升产品和企业价值</p>
            </div>
        </div>
    </div>

    <?php if ($products) { ?>
        <div class="container-fluid">
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-sm-3 col-xs-6">
                <div class="folio-item wow fadeInRightBig" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="folio-image">
                        <img class="img-responsive" src="<?= $product->img->getOriginImageUrl() ?>" alt="">
                    </div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <div class="overlay-text">
                                <div class="folio-info">
                                    <h3><?= $product->name ?></h3>
                                    <p><?= $product->title ?></p>
                                </div>
                                <div class="folio-overview">
                                    <span class="folio-link"><a class="folio-read-more" href="/product_detail/<?= $product->id ?>.html" data-single_url="portfolio-single.html" ><i class="fa fa-link"></i></a></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <div id="portfolio-single-wrap">
        <div id="portfolio-single">
        </div>
    </div>
</section>
<!-- 案例 -->


<section id="services">
    <div class="container">
        <div class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <div class="row">
                <div class="text-center col-sm-8 col-sm-offset-2">
                    <h1>彰显气质与提升价值</h1>
                    <h2>我们的服务</h2>
                    <p>我们专注用户体验设计和开发，宾至如归"的服务体验</p>
                </div>
            </div>
        </div>
        <?php if ($services) { ?>
            <div class="text-center our-services">
                <div class="row">
                    <?php $delay = 300; foreach ($services as $service) { ?>
                        <div class="col-sm-2 col-xs-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                            <div class="fake_box">
                                <div class="service-icon serve_01" style="background: url(<?=$service->img ? $service->img->getOriginImageUrl() : '' ?>) no-repeat;">
                                    <!--<i class="fa fa-flask"></i>-->
                                </div>
                                <div class="service-info">
                                    <h4><?= $service->name ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php $delay += 100; } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section><!--我们的服务-->

<section id="about-us" class="parallax">
    <div class="container">
        <div class="row">
            <div class="about-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h1>让我们协助您</h1>
                <h2>关于<?= Yii::$app->name ?></h2>
                <p>
                    <?= $description ?>
                </p>
                <div class="load-more wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
                    <a href="<?= Url::to(['/about']) ?>" class="btn-loadmore">了解更多</a>
                </div>
            </div>
        </div>
    </div>
</section><!--关于-->

<section id="features" class="parallax">
    <div class="container">
        <div class="row">
            <div class="about-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h1>以品牌为核心</h1>
                <h2><?= Yii::$app->name ?>观点</h2>
                <p>企业、品牌、产品三者密不可分。<br>
                    产品是企业与消费者连接的纽带，消费者通过产品认识企业、认识品牌。<br>
                    在激烈的市场竞争中，不仅要深层次挖掘客户需求，精准的设计和营销策略起到至关重要的作用，<br>
                    才会有刷新市场结构的可能。</p>
                <div class="load-more wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
                    <a href="#" class="btn-loadmore">探索更多</a>
                </div>
            </div>
        </div>
    </div>
</section><!--观点-->


<section id="team">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                <h1>彰显气质与提升价值</h1>
                <h2>我们的客户</h2>
                <p>我们持续为众多国内外知名企业提供创意与专业的设计服务。</p>
            </div>
        </div>
        <?php if ($partners) { ?>
            <div class="team-members">
                <div class="row">
                    <?php $delay= 300; foreach ($partners as $partner) { ?>
                        <div class="col-sm-2">
                            <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                                <div class="member-image">
                                    <img class="img-responsive" src="<?=$partner->img ? $partner->img->getOriginImageUrl() : '' ?>" alt="">
                                </div>
                            </div>
                        </div>
                    <?php $delay += 100; } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section><!--我们的客户-->

<section id="blog" style="padding-top:0px;">
    <div class="container">
        <div class="blog-posts">
            <?php if ($news) { ?>
                <div class="row">
                    <?php foreach ($news as $ns) { ?>
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <a href="/news_detail/<?= $ns->id ?>.html"><img class="img-responsive" src="<?= $ns->img ? $ns->img->getOriginImageUrl() : ''?>" alt=""></a>
                            </div>
                            <div class="entry-header">
                                <h3><a href="<?= Url::to(['news/detail', 'id' => $ns->id]) ?>"><?= $ns->title ?></a></h3>
                                <span class="date"><?= date('Y-m-d', $ns->created_at) ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="load-more wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
                <a href="<?= Url::to(['/news']) ?>" class="btn-loadmore">更多新闻</a>
            </div>
        </div>
    </div>
</section><!--新闻-->
