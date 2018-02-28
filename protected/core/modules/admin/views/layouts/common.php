<?php
/**
 * @var $this yii\web\View
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use core\modules\admin\widgets\CompanyLogo;
?>

<?php $this->beginContent('@core/modules/admin/views/layouts/base.php'); ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <?= CompanyLogo::widget() ?>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo Yii::t('AdminModule.views_layouts_common', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li>
                            <?php echo Html::a(
                            '<i class="fa fa-bookmark-o"></i> ' . Yii::t('AdminModule.views_layouts_common', 'Frontend Site'),
                                '/'
                            ) ?>
                        </li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/static/img/default_user.jpg" class="user-image">
                                <span><?php echo Yii::$app->admin->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header light-blue">
                                    <img src="/static/img/default_user.jpg" class="img-circle" alt="User Image"/>
                                    <p>
                                        <?php echo Yii::$app->admin->identity->username ?>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <?php echo Html::a(Yii::t('AdminModule.views_layouts_common', 'Logout'),
                                            ['/admin/index/logout'],
                                            ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php echo Html::a('<i class="fa fa-cogs"></i>', 'javascript:void(0);',
                                ['data-toggle' => 'control-sidebar']) ?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left menu start -->
        <?= $this->render('left_menu') ?>
        <!-- Left menu end -->

        <!-- layout setting start -->
        <?= $this->render('layout_setting') ?>
        <!-- layout setting end -->

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?php echo $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>

                <?php echo Breadcrumbs::widget([
                    'tag' => 'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?=dmstr\widgets\Alert::widget() ?>
                <?php echo $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b><?php echo Yii::t('AdminModule.base', 'Welcome use Yii Shop.'); ?></b>
            </div>
            <strong> Powered by <a href="http://www.yiiframework.com" target="_blank"> Yii2 framework </a>.</strong>
        </footer>

    </div><!-- ./wrapper -->

<?php $this->endContent(); ?>
