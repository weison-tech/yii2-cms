<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

$this->title = Yii::t('HomeModule.base', 'Company Info');
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $model core\modules\home\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'latitude')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'longitude')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo')->widget('core\modules\file\widgets\Upload',
        [
            'url' => ['/file/file/upload'],
            'maxFileSize' => 10 * 1024 * 1024, // 10 MiB,
            'minFileSize' => 1,
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]
    ); ?>

    <?= $form->field($model, 'thumb')->widget('core\modules\file\widgets\Upload',
        [
            'url' => ['/file/file/upload'],
            'maxFileSize' => 10 * 1024 * 1024, // 10 MiB,
            'minFileSize' => 1,
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]
    ); ?>

    <?= $form->field($model, 'm_thumb')->widget('core\modules\file\widgets\Upload',
        [
            'url' => ['/file/file/upload'],
            'maxFileSize' => 10 * 1024 * 1024, // 10 MiB,
            'minFileSize' => 1,
            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]
    ); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget('kucha\ueditor\UEditor',[]) ?>

    <div class="form-group field-subsection-url has-success">
        <label class="control-label" for="subsection-url">搜索位置</label>
        <div id="r-result">
            <input type="text" id="suggestId" class="form-control"  maxlength="128" aria-invalid="false">
        </div>

        <div id="l-map"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    #l-map{height:300px;width:100%;}
    #r-result{width:100%;}
</style>

<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=oFlwfUgtH5l4Cv0CDmI44sxk9fN3Df9w"></script>

<div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>

<script type="text/javascript">
    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    //初始化地图,设置城市和地图级别。
    var map = new BMap.Map("l-map");

    var subsection_lng = $("#company-longitude").val();
    var subsection_lat = $("#company-latitude").val();
    if (subsection_lng.length > 0 && subsection_lat.length > 0) { //坐标定位
        var point = new BMap.Point(subsection_lng, subsection_lat);
        map.centerAndZoom(point, 18);
        map.addOverlay(new BMap.Marker(point));    //添加标注
    } else {
        map.centerAndZoom("<?= $model-> name?>", 18);
    }


    //建立一个自动完成的对象
    var ac = new BMap.Autocomplete({"input" : "suggestId", "location" : map});

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

        setPlace();
    });

    map.addEventListener("click",function(e){
        var marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat));  // 创建标注
        $("#company-longitude").val(e.point.lng);
        $("#company-latitude").val(e.point.lat);
        map.clearOverlays();
        map.addOverlay(marker);
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            $("#company-longitude").val(pp.lng);
            $("#company-latitude").val(pp.lat);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
            onSearchComplete: myFun
        });
        local.search(myValue);
    }
</script>
