<footer id="footer">
    <div class="footer-top" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="container text-center">
            <div class="footer-logo">
                <a href="index.html"><img class="img-responsive" src="<?= $logo_url ?>" alt=""></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom fadeINup wow" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="container">
            <div class="row footer_list">
                <?php foreach ($items as $v) { ?>
                    <div class="row-content col-sm-2">
                        <h4><?= $v['main']['title'] ?></h4>
                        <?php if ($v['child']) { ?>
                            <ul>
                                <?php foreach ($v['child'] as $child) { ?>
                                    <li><a href="<?= $child['url']?>"><?= $child['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="row-content col-sm-2">
                    <h4>频道</h4>
                    <?php if ($links) { ?>
                        <ul>
                            <?php foreach ($links as $link) { ?>
                                <li>
                                    <a href="<?= $link->url ?>">
                                        <i style="background: url(<?= $link->img->getOriginImageUrl() ?>) no-repeat;
                                                display: inline-block;
                                                width: 15px;
                                                height: 15px;
                                                margin-right: 8px;
                                                vertical-align: middle;
                                                background-size: 15px!important;
                                        "></i>
                                        <?= $link->name ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="row record">
                <div class="col-lg-12 text-center">
                    <p style="color: #B3B3B3">Copyright&copy;2016 <?= Yii::$app->name ?> , All Rights Reserved </p>
                </div>
            </div>
            <div class="row footer_rad">
                <div class="min_box text-center">
                    <ul class="list-unstyled">
                        <?php if ($links) { foreach ($links as $link) { ?>
                            <li class="footer-box">
                                <a href="<?= $link->url ?>">
                                    <i style="background: url(<?= $link->img->getPreviewImageUrl(49, 45) ?>) no-repeat;"></i>
                                    <?= $link->name ?>
                                </a>
                            </li>
                        <?php } } ?>
                        <li><a href=""><img class="footer_logo" src="<?= $logo_url ?>"></a></li>
                        <li>
                            <a href="#">
                                <i class="retur glyphicon glyphicon-triangle-top"></i>
                                <div>返回顶部</div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>