<?php

use yii\helpers\Html;
use leandrogehlen\treegrid\TreeGrid;
use yii\helpers\Url;
use yii2mod\editable\EditableColumn;

/* @var $this yii\web\View */
/* @var $searchModel core\modules\news\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('NewsModule.base', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a("<i class='fa fa-angle-double-down'></i> <span>" . Yii::t('NewsModule.base',
                'Open All') . '</span>', 'javascript:void(0)', ['class' => 'btn btn-info btn-flat', 'id' => 'toggle']) ?>
        <?= Html::a(Yii::t('NewsModule.base', 'Create Category'), ['create'],
            ['class' => 'btn btn-success btn-flat']) ?>
    </p>
    <?= TreeGrid::widget([
        'dataProvider' => $dataProvider,
        'keyColumnName' => 'id',
        'parentColumnName' => 'parent_id',
        'parentRootValue' => '0', //first parentId value
        'pluginOptions' => [
            'initialState' => 'collapsed',
        ],
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return $model->parent ? $model->parent->name : '-';
                },
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'sort_order',
                'url' => ['change-sort'],
            ],
            [
                'attribute' => 'thumb',
                'content' => function ($model) {
                    return $model->img ? Html::img($model->img->getPreviewImageUrl(200, 200),
                        ['style' => 'width:100px;height:100px;']) : '-';
                },
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
                'class' => 'core\modules\admin\widgets\ActionColumn',
                'options' => ['style' => 'width:240px;'],
            ],
        ],
    ]); ?>

</div>

<script type="text/javascript">
    $(function () {
        $("#toggle").click(function () {
            var flg = $(this).find("i");
            if (flg.hasClass('fa-angle-double-down')) {
                var close = "<?=Yii::t('NewsModule.base', 'Close All')?>";
                $(this).find('span').text(close);
                flg.removeClass('fa-angle-double-down');
                flg.addClass('fa-angle-double-up');

                $(".treegrid-expander-collapsed").each(function () {
                    $(this).click();
                })
            } else {
                var open = "<?=Yii::t('NewsModule.base', 'Open All')?>";
                $(this).find('span').text(open);
                flg.removeClass('fa-angle-double-up');
                flg.addClass('fa-angle-double-down');

                $(".treegrid-expander-expanded").each(function () {
                    $(this).click();
                })
            }
        })
    })

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
