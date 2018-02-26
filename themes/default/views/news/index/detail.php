<?php
use yii\helpers\Url;

$this->pageTitle = '动态详情';
?>

<section id="new_list">
    <div class="container-fluid">
        <div class="row retu wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <a href="<?= Url::to(['/news']) ?>"><i class="glyphicon glyphicon-menu-left"></i>  返回</a>
            <div class="entry-header">
                <h3><?= $model->title ?></h3>
                <span class="date"><?= date('Y-m-d', $model->created_at) ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12 pull-right">
                <div class="row">
                    <?php if ($model->album) { $delay = 300; foreach ($model->album as $k => $v) { ?>
                        <div class="col-sm-12">
                            <div class=" wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="folio-image">
                                    <img class="img-responsive" src="<?= $v->getOriginImageUrl() ?>" alt="">
                                </div>
                                <p><?= $v->getName() ?></p>
                            </div>
                        </div>
                    <?php $delay += 100; } } ?>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 pull-right pad_rig">
                <div class="row">
                    <div class="col-sm-12">
                        <div class=" wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="media">
                                <div class="news_content">
                                    <?= $model->content ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>