<?php

/* @var $this \yii\web\View */

$this->params['sidebar'] = [
    [
        'label' => Yii::t('AdminModule.rbac_base', 'Assignments'),
        'url' => ['/admin/rbac/assignment/index'],
    ],
    [
        'label' => Yii::t('AdminModule.rbac_base', 'Roles'),
        'url' => ['/admin/rbac/role/index'],
    ],
    [
        'label' => Yii::t('AdminModule.rbac_base', 'Permissions'),
        'url' => ['/admin/rbac/permission/index'],
    ],
    [
        'label' => Yii::t('AdminModule.rbac_base', 'Routes'),
        'url' => ['/admin/rbac/route/index'],
    ],
    [
        'label' => Yii::t('AdminModule.rbac_base', 'Rules'),
        'url' => ['/admin/rbac/rule/index'],
    ],
];
