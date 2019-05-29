<?php
/**
 * @author xiaomalover <xiaomalover@gmail.com>
 */

use yii\helpers\Url;

?>

<div class="row">

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green text-center">
            <div class="inner">
                <h3>200</h3>
                <p>NNNNNNNNN</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?php if (Yii::$app->admin->can('/news/admin/*')) { ?>
                <a href="<?= Url::to(['/news/admin/news'])?>" class="small-box-footer"><?= Yii::t('base', 'View') ?> <i class="fa fa-arrow-circle-right"></i></a>
            <?php } ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua text-center">
            <div class="inner">
                <h3>500</h3>
                <p>CCCCCCCCCCCCC</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?php if (Yii::$app->admin->can('/products/admin/*')) { ?>
                <a href="<?= Url::to(['/products/admin/products'])?>" class="small-box-footer"><?= Yii::t('base', 'View') ?> <i class="fa fa-arrow-circle-right"></i></a>
            <?php } ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue text-center">
            <div class="inner">
                <h3>1000</h3>
                <p>XXXXXXXXX</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?php if (Yii::$app->admin->can('/home/admin/*')) { ?>
                <a href="<?= Url::to(['/home/admin/contact'])?>" class="small-box-footer"><?= Yii::t('base', 'View') ?> <i class="fa fa-arrow-circle-right"></i></a>
            <?php } ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red text-center">
            <div class="inner">
                <h3><?=$manager_user_count?></h3>
                <p><?= Yii::t('AdminModule.base', 'Manager User Count') ?></p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?php if (Yii::$app->admin->can('/admin/admin/*')) { ?>
                <a href="<?= Url::to(['/admin/admin'])?>" class="small-box-footer"><?= Yii::t('base', 'View') ?> <i class="fa fa-arrow-circle-right"></i></a>
            <?php } ?>
        </div>
    </div>


    <!-- /.box-header -->
    <div class="box-body">

        <p style="font-size: 20px;margin-left:5px; margin-top: 100px;">
            <?= Yii::t('AdminModule.base', 'System Info') ?>
        </p>

        <table class="table no-margin" style="margin-left: 5px;">
            <tbody>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Operator System') ?></td>
                <td><?= PHP_OS ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Web Server') ?></td>
                <td><?= $_SERVER ['SERVER_SOFTWARE']; ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'PHP Version') ?></td>
                <td><?= PHP_VERSION ?></td>
            </tr>

            <?php
            $query = new \yii\db\Query();
            $a = $query->select('VERSION() as mysql_version;')->one();
            $mysql_version = isset($a['mysql_version']) ? $a['mysql_version'] : '-';
            ?>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Mysql Version') ?></td>
                <td><?= $mysql_version ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Zend Version') ?></td>
                <td><?= zend_version() ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Yii Version') ?></td>
                <td><?= Yii::getVersion() ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Soft Version') ?></td>
                <td><?= Yii::$app->getVersion() ?></td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Support Language') ?></td>
                <td>
                    <?= implode(";", array_values(Yii::$app->params['availableLanguages'])) ?>
                </td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Author') ?></td>
                <td>
                    weison-tech
                </td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Author Web Site') ?></td>
                <td>
                    <a target="_blank" href="http://www.itweshare.com">www.itweshare.com</a>
                </td>
            </tr>

            <tr>
                <td><?= Yii::t('AdminModule.base', 'Author Email') ?></td>
                <td>
                    xiaomalover@gmail.com
                </td>
            </tr>

            </tbody>
        </table>
    </div>

</div>
