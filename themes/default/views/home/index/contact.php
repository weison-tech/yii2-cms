<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->pageTitle = '联系';
?>

<section class="container">
    <div class="row wow fadeInUp log_img" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="col-sm-3 col-xs-12 text-center conten_log">
            <img src="<?= ($company && $company->img) ? $company->img->getOriginImageUrl() : '/themes/default/images/logo.png' ?>" alt=""/>
        </div>
        <div class="col-sm-3 col-xs-12 contact-li">
            <h3><?= $company ? $company->name : '' ?></h3>
            <h4><?= $company ? $company->en_name : '' ?></h4>
            <ul class="list-unstyled" id="ico">
                <?php if ($links) { foreach ($links as $link) { ?>
                    <li>
                        <a href="<?= $link->url ?>">
                            <i class="zcool" style="background: url(<?= $link->img ? $link->img->getOriginImageUrl() : ''?>) no-repeat;"></i>
                            <?= $link->name ?>
                        </a>
                    </li>
                <?php } } ?>
            </ul>
        </div>
        <div class="col-sm-3 col-sm-offset-3 contact-add">
            <div class="site"><?= $company ? $company->address : '' ?></div>
            <p class="touch">电话： <?= $company ? $company->mobile : '' ?></p>
            <p class="touch">邮箱： <?= $company ? $company->email : '' ?></p>
        </div>
    </div>
    <div class="row wow fadeInUp contact_mid" data-wow-duration="1000ms" data-wow-delay="400ms">
        <div class="col-sm-12">
            <div  id="l-map" >

            </div>
        </div>
    </div>
    <div class="row wow fadeInUp text-center leave" data-wow-duration="1000ms" data-wow-delay="500ms">
        <div class="col-sm-8 col-sm-offset-2 contact-text">
            <h5>如阁下有任何咨询或希望商讨合作机会，请留下您的信息，我们会尽快回复您。</h5>
            <span><?=dmstr\widgets\Alert::widget() ?></span>
        </div>
    </div>
    <div class="row wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="600ms">
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'fieldConfig' => [
                'template' => '<div class="col-sm-12">{input}{error}</div>',
                'inputOptions' => ['class' => ''],
            ],
        ]); ?>
        <div class="col-sm-4 col-xs-12 personal_message">


            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => '您的姓名']) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => '邮 箱']) ?>

            <?= $form->field($model, 'mobile')->textInput(['placeholder' => '电 话']) ?>

            <?= $form->field($model, 'company')->textInput(['placeholder' => '公司名称']) ?>


        </div>
        <div class="col-sm-8 col-xs-12 personal_need">
            <?= $form->field($model, 'demand')->textarea(['rows' => 6, 'placeholder' => "您的需求描述？"]) ?>
            <div class="refer">
                <button>发送需求</button>
                <p>或者发送商务质询到邮箱：<?= $company ? $company->email : '' ?></p>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>


<script type="text/javascript" src="https://api.map.baidu.com/getscript?v=2.0&ak=GA0ZcT9NV96rSaeKEDl0Scjtet9A4gTj&s=1"></script>
<script type="text/javascript">
    //初始化地图,设置城市和地图级别。
    var map = new BMap.Map("l-map");
    var is_pc = IsPC();
    var height = is_pc ? "473px" : "115px";
    window.document.getElementById("l-map").style.height = height;

    var subsection_lng = '<?= $company ? $company->longitude : 0 ?>';
    var subsection_lat = '<?= $company ? $company->latitude : 0 ?>';
    if (subsection_lng.length > 0 && subsection_lat.length > 0) { //坐标定位
        var point = new BMap.Point(subsection_lng, subsection_lat);
        map.centerAndZoom(point, 18);
        map.addOverlay(new BMap.Marker(point));    //添加标注
    } else {
        map.centerAndZoom("<?= $company ? $company -> name : '' ?>", 18);
    }

    map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用

    function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
            "SymbianOS", "Windows Phone",
            "iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }

</script>