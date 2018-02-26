<?php
    $this->pageTitle = '服务';
?>

<section id="services" class="service_details">
    <div class="service_top">
        <div class="text-center our-services">
            <div class="row all_type">
                <?php if ($lists) { $delay = 300; foreach ($lists as $item) { ?>
                    <div class="col-sm-2 col-xs-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <div class="fake_box">
                            <div class="service-icon serve_01" style="background: url(<?= $item->img ? $item->img->getOriginImageUrl() : ''?>) no-repeat;">
                            </div>
                            <div class="service-info">
                                <h4><?= $item->name ?></h4>
                            </div>
                        </div>
                    </div>
                <?php $delay += 100; } } ?>
            </div>
            <div class="row service_list">
                <?php if ($lists) { $delay = 300; foreach ($lists as $item) { ?>
                    <div class="col-sm-2 col-xs-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <ul class="list-unstyled text-left">
                            <?php if ($item->child) { foreach ($item->child as $c) { ?>
                                <li><?= $c->name ?></li>
                            <?php } } ?>
                        </ul>
                    </div>
                <?php $delay += 100; } } ?>
            </div>
        </div>
    </div>
</section><!--/#services-->
<section style="padding-bottom: 10px"></section>