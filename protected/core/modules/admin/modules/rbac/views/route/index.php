<?php

use yii\helpers\Html;
use yii\helpers\Json;
use core\modules\admin\modules\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->title = Yii::t('AdminModule.rbac_base', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>

<?php echo Html::a(Yii::t('AdminModule.rbac_base', 'Refresh'), ['refresh'], [
    'class' => 'btn btn-primary',
    'id' => 'btn-refresh',
]); ?>
<?php echo $this->render('../_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $routes,
    ]),
    'assignUrl' => ['assign'],
    'removeUrl' => ['remove'],
]); ?>
