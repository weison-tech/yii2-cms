<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel core\modules\home\models\search\CantactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('HomeModule.base', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <div class="navbar navbar-default">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <p>
        <?= Html::a(Yii::t('HomeModule.base', 'Batch Read'), 'javascript:void(0);', ['class' => 'btn btn-success btn-flat', 'id' => 'batchRead']) ?>
        <?= Html::a(Yii::t('HomeModule.base', 'Batch Delete'), 'javascript:void(0);', ['class' => 'btn btn-danger  btn-flat', 'id' => 'batchDelete']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'name',
            'company',
            'mobile',
            'email:email',
            'demand:ntext',
            'created_at:datetime',
            [
                'attribute'=>'status',
                'value'=> function ($model) {
                    return $model::getStatus($model->status);
                },
                'format' => 'raw',
            ],
            [
                'class' => 'core\modules\admin\widgets\ActionColumn',
                'options' => ['style' => 'width:240px;'],
                'template' => '{view}  {delete}',
            ],
        ],
    ]); ?>
</div>


<?php
//The url
$urlBatchRead = Url::to(['batch-read']);
$urlBatchDelete = Url::to(['batch-delete']);

//The confirm message
$messageRead = Yii::t('HomeModule.base', 'Are you sure to mark these items as read?');
$messageDelete = Yii::t('HomeModule.base', 'Are you sure to delete these items?');

//The layer's message
$confirmBtn = Yii::t('base', 'Ok');
$cancelBtn = Yii::t('base', 'Cancel');
$emptyMsg = Yii::t('base', 'Please check some item');
$handingMsg = Yii::t('base', 'Processing, please wait...');

$js = <<<JS
jQuery(document).ready(function() {
   
    /*
     * Ajax batch read message.
     */
    $("#batchRead").click(function() {
        var keys = $(".grid-view").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.msg("{$emptyMsg}");
            return;  
        }
        layer.confirm("{$messageRead}", {
            btn: ["{$confirmBtn}", "{$cancelBtn}"] 
        }, function(){
            $.ajax({
                type: "POST",
                url: "{$urlBatchRead}",
                dataType: "json",
                data: {ids: keys},
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    layer.closeAll();
                }
            });
        });
    });
    
    /*
     * Ajax batch delete message.
     */
    $("#batchDelete").click(function() {
        var keys = $(".grid-view").yiiGridView("getSelectedRows");
        if (keys.length == 0) {
            layer.msg("{$emptyMsg}");
            return;  
        }
        
        layer.confirm("{$messageDelete}", {
            btn: ["{$confirmBtn}", "{$cancelBtn}"] 
        }, function(){
            $.ajax({
                type: "POST",
                url: "{$urlBatchDelete}",
                dataType: "json",
                data: {ids: keys},
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    layer.closeAll();
                }
            });
        });
        
        /**
        * If in other case, you need layer prompt, please refer to the following code.      
        */
        /*layer.prompt({title: "You title", formType: 2}, function(reasons, index){
            $.ajax({
                type: "POST",
                url: "You ajax url",
                dataType: "json",
                data: {ids: keys, reasons:reasons},
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    layer.closeAll();
                }
            });
        });*/
        
    });
    
});

JS;
$this->registerJs($js, View::POS_END);

