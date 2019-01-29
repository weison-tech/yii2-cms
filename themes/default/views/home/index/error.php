<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h1>啊哟，貌似出现了错误</h1>
                <h2 style="color:#ff9933;"><?php print_r($exception->statusCode); ?></h2>
                <p><?= nl2br(Html::encode($message)) ?></p>
            </div>
        </div>
    </div>
</section>
