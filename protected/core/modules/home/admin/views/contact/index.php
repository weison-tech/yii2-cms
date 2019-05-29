<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
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

<script type="text/javascript">
    /**
     * Ajax change status.
     * @param o
     */
    function changeStatus(o) {
        var url = "<?= Url::to(['change-status']) ?>";
        var data = {id:$(o).attr('data-id')};
        $.post(url, data, function (data) {
            var res =  eval('(' + data + ')');
            if (res.code == '200') {
                if($(o).css('color') == "rgb(128, 128, 128)") {
                    $(o).css('color', 'green');
                } else {
                    $(o).css('color', 'grey');
                }
            }
        });
    }
</script>
