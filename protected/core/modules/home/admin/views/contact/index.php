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

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'label' => Yii::t('base', 'Operation'),
                'format' => 'raw',
                'value' => function ($data) {
                    $viewUrl = Url::to(['view', 'id' => $data->id]);
                    $updateUrl = Url::to(['update', 'id' => $data->id]);
                    $deleteUrl = Url::to(['delete', 'id' => $data->id]);
                    return "<div class='btn-group'>" .
                        Html::a(Yii::t('base', 'View'), $viewUrl,
                            ['title' => Yii::t('base', 'View'), 'class' => 'btn btn-sm btn-info']) .
                        Html::a(Yii::t('base', 'Delete'), $deleteUrl, [
                            'title' => Yii::t('base', 'Delete'),
                            'class' => 'btn btn-sm btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('base', 'Are you sure you want to delete this item?')
                        ]) .
                        "</div>";
                },
                'options' => ['style' => 'width:175px;'],
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
