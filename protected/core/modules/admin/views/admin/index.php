<?php

use core\modules\admin\models\Admin;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel core\modules\admin\models\search\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('AdminModule.widgets_AdminMenu', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .a-upload{
        padding: 0 12px;
        height: 35px;
        line-height: 35px;
        position: relative;
        cursor: pointer;
        color: #fff;
        background-color: #00a65a;
        border-color: #008d4c;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1;
        /*/border-radius: 4px;*/
    }
    .a-upload input{
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer
    }
    .a-upload:hover{
        color: #FFFFFF;
        background: #008d4c;
        border-color: #204d74;
        text-decoration: none;
    }
    .a-upload1 input{
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer
    }
    .instructions {
        padding: 0 12px;
        height: 35px;
        line-height: 35px;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1;
    }
</style>

<div class="box-body table-responsive no-padding">

    <div class="navbar navbar-default">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>

    <p>
        <?= Html::a(Yii::t('AdminModule.base', 'Create Admin'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </p>

    <div class="pull-right" style="margin-top: -45px; margin-right: 20px;">
        <form id="uploadForm">
            <a class="instructions"><?=Yii::t("AdminModule.base", "Instructions") ?></a>
            <a href="javascript:;" class="a-upload"><input type="file" name="create-admin" id="batch-create-admin">
                <i class="fa fa-arrow-circle-up"></i><?= ' Excel ' . Yii::t('AdminModule.base', 'Batch Create') ?>
            </a>
        </form>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'headerRowOptions' => ['class' => 'text-center'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
             'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Admin::$stat[$model->status];
                },
                'filter' => Admin::$stat,
            ],
            [
                'attribute' => 'created_at',
                'content' => function ($model) {
                    return date("Y-m-d H:i:s", $model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'content' => function ($model) {
                    return date("Y-m-d H:i:s", $model->updated_at);
                },
            ],
            [
                'class' => 'core\modules\admin\widgets\ActionColumn',
                'options' => ['style' => 'width:240px;'],
            ],
        ],
    ]); ?>
</div>

<?php
$confirmMsg = Yii::t("AdminModule.base", "Please use the Excel form of the flyer Sheet, which must contain the headers and contents of 'Username', 'Email', 'Password'");
$confirmBtn = Yii::t('base', 'Ok');
$cancelBtn = Yii::t('base', 'Cancel');
$excelPassUrl = Url::to(['excel-create']);
$handingMsg = Yii::t('base', 'Processing, please wait...');
$js = <<<JS
jQuery(document).ready(function() {
   $(".instructions").click(function() {
        layer.confirm("{$confirmMsg}", {
            btn: ["{$confirmBtn}", "{$cancelBtn}"] 
        });
   })
   
   var uploading = false;
    $("#batch-create-admin").on("change", function(){
        if(uploading){
            layer.msg("{$handingMsg}");
            return false;
        }
        
        var formData = new FormData($('#uploadForm')[0]);
    
        var loadingIndex;
        $.ajax({
            url: "{$excelPassUrl}",
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            dataType:"json",
            beforeSend: function(){
                uploading = true;
                loadingIndex = layer.load(1, {
                  shade: [0.5,'#000']
                });
            },
            success : function(data) {
                uploading = false;
                layer.close(loadingIndex);
                layer.msg(data.msg);
                setTimeout(function() {
                    location.reload();
                }, 1000)
            }
        });
    });
});

JS;
$this->registerJs($js, View::POS_END);

