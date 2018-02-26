<?php
    $this->pageTitle = '关于';
?>

<section id="about" class="">
    <div class="container">
        <div class="row about_headline">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12 wow fadeInUp text-center" data-wow-duration="1200ms"
                 data-wow-delay="300ms">
                <h2><?= $company->en_name ?></h2>
                <p>
                    <?= $company->description ?>
                </p>
            </div>
        </div>
        <div class="row about_img">
            <div class="col-sm-12  col-xs-12 wow fadeInUp text-center" data-wow-duration="1200ms"
                 data-wow-delay="300ms">
                <div class="pc_show"><img src="<?= $company->thu ? $company->thu->getOriginImageUrl() : '/themes/default/images/about_01.png' ?>" alt=""/></div>
                <div class="pc_hide"><img src="<?= $company->mThu ? $company->mThu->getOriginImageUrl() : '/themes/default/images/about_02.png' ?>" alt=""/></div>
            </div>
        </div>
        <div class="row disposition">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms"
                 data-wow-delay="300ms">
                <h1>彰显气质与提升价值</h1>
                <h2>我们的客户</h2>
                <p>我们持续为众多国内外知名企业提供创意与专业的设计服务。</p>
            </div>
        </div>
        <div class="row client">
            <?php if ($partners) { $delay = 300; foreach ($partners as $p) { ?>
                <div class="col-sm-2 col-xs-4">
                    <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <div class="member-image">
                            <img class="img-responsive" src="<?=$p->img ? $p->img->getOriginImageUrl() : '' ?>" alt="">
                        </div>
                    </div>
                </div>
            <?php $delay += 100; }  } ?>
        </div>
    </div>
</section><!--/#services-->

<script type="text/javascript" src="/themes/default/js/mousescroll.js"></script>

