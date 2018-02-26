<?php if ($items) { ?>

<div id="home-slider" class="carousel slide carousel-fade" data-ride="carousel" style="margin-top: 0px">
    <div class="carousel-inner">
        <?php foreach ($items as $k => $item) { ?>
            <div class="item <?= $k == 1 ? 'active' : ''?>" style="background-image: url(<?= $item->img->getPreviewImageUrl(1400, 827) ?>)">
                <div class="caption">
                    <div class="text-left">
                        <h1 class="animated fadeInLeftBig"><?= $item->name ?></h1>
                        <p class="animated fadeInRightBig"><?= $item->title ?></p>
                        <a data-scroll class="btn btn-start animated fadeInUpBig" href="<?= $item->url ?>">Start now</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <a class="blog-left-control" href="#home-slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
    <a class="blog-right-control" href="#home-slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
    <a id="tohash" href="#services"><i class="fa fa-angle-down"></i></a>
</div><!--banner-->

    <?php } ?>