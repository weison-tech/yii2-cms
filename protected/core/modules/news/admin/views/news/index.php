<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii2mod\editable\EditableColumn;

/* @var $this yii\web\View */
/* @var $searchModel core\modules\products\models\search\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('NewsModule.base', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('NewsModule.base', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'thumb',
                'content' => function ($model) {
                    return $model->img ? Html::img($model->img->getPreviewImageUrl(200, 200),
                        ['style' => 'width:100px;height:100px;']) : '-';
                },
            ],
            [
                'attribute'=>'category_id',
                'value'=> function ($model) {
                    return $model->category ? $model->category->name : '-';
                },
                'format' => 'raw',
            ],
            'title',
            [
                'class' => EditableColumn::class,
                'attribute' => 'sort_order',
                'url' => ['change-sort'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->status ?
                        "<i class='fa fa-check-circle' 
                            style='color: green; font-size: 25px; cursor: pointer;' 
                            onclick='changeStatus(this)'
                            data-id='". $model->id ."'" . "                           
                        ></i>" :
                        "<i class='fa fa-times-circle' 
                            style='color: red; font-size: 25px; cursor: pointer;'
                            onclick='changeStatus(this)'
                            data-id='". $model->id ."'" . "                    
                        ></i>";
                },
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
                        Html::a(Yii::t('base', 'Update'), $updateUrl,
                            ['title' => Yii::t('base', 'Update'), 'class' => 'btn btn-sm btn-primary']) .
                        Html::a(Yii::t('base', 'Delete'), $deleteUrl, [
                            'title' => Yii::t('base', 'Delete'),
                            'class' => 'btn btn-sm btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('base', 'Are you sure you want to delete this item?')
                        ]) .
                        "</div>";
                },
                'options' => ['style' => 'width:175px;'],
            ]
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
                if($(o).hasClass('fa-times-circle')) {
                    $(o).removeClass('fa-times-circle');
                    $(o).addClass('fa-check-circle');
                    $(o).css('color', 'green');
                } else {
                    $(o).removeClass('fa-check-circle');
                    $(o).addClass('fa-times-circle');
                    $(o).css('color', 'red');
                }
            }
        });
    }
</script>

