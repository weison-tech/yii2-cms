<?php
use yii\helpers\Url;

$this->pageTitle = '动态';
?>

<section class="container">
    <div class="row container wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms" id="dynamic_nav">
        <div class="col-sm-12">
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?= !isset($_GET['id']) ? 'active' : '' ?>"><a href="<?= Url::to(['/news']) ?>">全部</a></li>
                    <?php if ($cate) { foreach ($cate as $c) { ?>
                        <li class="<?= isset($_GET['id']) && $_GET['id'] == $c->id ? 'active' : '' ?>"><a href="<?= Url::to(['/news', 'id' => $c->id]) ?>"><?= $c->name ?></a></li>
                    <?php } } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="dynamic_details">
    <div class="container-fluid">
        <?php if ($model) { $delay = 300; foreach ($model as $item) { ?>
            <div class="row">
                <div class="col-sm-6 col-xs-12 pull-right">
                    <div class="wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <div class="folio-image">
                            <a href="<?= Url::to(['/news_detail/'. $item->id]) ?>">
                                <img class="img-responsive" src="<?= $item->img ? $item->img->getOriginImageUrl() : ''?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 pull-right pad_rig">
                    <div class=" wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="<?= $delay ?>ms">
                        <div class="media">
                            <div class="media-body">
                                <div class="midia-heading">
                                    <h3><a href="<?= Url::to(['/news_detail/'. $item->id]) ?>"><?= $item->title ?></a></h3>
                                </div>
                            </div>
                            <div class="news_content">
                                <?= $item->summary ?>
                            </div>
                            <span class="data"><?= date('Y-m-d', $item->created_at) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php $delay++; } } ?>

        <?php if ($pages->totalCount > $pages->pageSize) { ?>
            <div class="row pag wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="col-sm-12 text-center pagination">
                    <?= \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'options' => ['css' => 'list-unstyled']
                    ]); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>