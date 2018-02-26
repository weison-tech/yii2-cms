<?php
use core\assets\AdminLteAsset;
use core\assets\AdminLayoutAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AdminLteAsset::register($this);
AdminLayoutAsset::register($this)
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo Html::encode($this->pageTitle); ?></title>
        <?php $this->head() ?>
    </head>
    <?php
        $class = ['sidebar-mini'];
        $settings = Yii::$app->getModule('admin')->settings;
        $settings->get('fixed') && $class[] = 'fixed';
        $settings->get('layout-boxed') && $class[] = 'layout-boxed';
        $settings->get('sidebar-collapse') && $class[] = 'sidebar-collapse';
        $skin = $settings->get('skin');
        $skin ? $class[] = $skin : $class[] = 'green';
        echo Html::beginTag('body', [
            'id' => 'body',
            'class' => $class,
        ])
    ?>
    <?php $this->beginBody() ?>
    <?php echo $content ?>
    <?php $this->endBody() ?>

    <!--layout setting-->
    <script type="text/javascript">
        $(function () {
            //Set layout
            $("#control-sidebar-theme-demo-options-tab").find('input').click(function(){
                var input = $(this);
                var name = false;
                if (input.attr('data-layout') != undefined) {
                    name = input.attr('data-layout');
                }

                if (input.attr('data-enable') != undefined) {
                    name = input.attr('data-enable');
                }

                if (input.attr('data-sidebarskin') != undefined) {
                    name = "sidebarSkin";
                }

                if (name != false) {
                    var value = input.is(':checked') ? 1 : 0;
                    setting(name, value);
                }
            });

            //Set skin
            $("[data-skin]").click(function(){
                var name = 'skin';
                var value = $(this).attr('data-skin');
                setting(name, value);
            })
        })

        function setting(name, value) {
            var url = "<?= Url::to(['/admin/index/ajax-layout-setting']) ?>";
            var data = {name:name, value:value};
            $.post(url, data);
        }
    </script>

    <?php echo Html::endTag('body') ?>
    </html>
<?php $this->endPage() ?>