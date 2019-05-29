<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-header">
    <?= "<?= " ?>Html::a(<?= $generator->generateCommonString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary btn-flat']) ?>
    <?= "<?= " ?>Html::a(<?= $generator->generateCommonString('Delete') ?>, ['delete', <?= $urlParams ?>], [
        'class' => 'btn btn-danger btn-flat',
        'data' => [
            'confirm' => <?= $generator->generateCommonString('Are you sure you want to delete this item?') ?>,
            'method' => 'post',
        ],
    ]) ?>
    <?= "<?= " ?>Html::a(<?= $generator->generateCommonString('Back To List') ?>, ['index'], ['class' => 'btn btn-info btn-flat']) ?>
</div>
<div class="box-body table-responsive no-padding">
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = stripos($column->name, 'created_at') !== false || stripos($column->name, 'updated_at') !== false ? 'datetime' : $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>
</div>
