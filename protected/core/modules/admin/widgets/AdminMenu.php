<?php
namespace core\modules\admin\widgets;

use Yii;

/**
 * Description of AdminMenu
 */
class AdminMenu extends \core\widgets\BaseMenu
{
    public function init()
    {
        $this->options = ['class' => 'sidebar-menu'];
        $this->addItem(
            [
                'label' => Yii::t('AdminModule.widgets_AdminMenu', 'System Setting'),
                'icon' => 'cog',
                'url' => '#',
                'sortOrder' => 11,
                'items' => [
                    ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Admins'), 'icon' => 'list', 'url' => ['/admin/admin'],],
                    [
                        'label' => Yii::t('AdminModule.widgets_AdminMenu', 'Permission Management'),
                        'icon' => 'group',
                        'url' => '#',
                        'sortOrder' => 1,
                        'items' => [
                            ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Assignment'), 'icon' => 'hand-pointer-o', 'url' => ['/admin/rbac/assignment'],],
                            ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Roles'), 'icon' => 'user', 'url' => ['/admin/rbac/role'],],
                            ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Permissions'), 'icon' => 'gavel', 'url' => ['/admin/rbac/permission'],],
                            ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'Rules'), 'icon' => 'globe', 'url' => ['/admin/rbac/route'],],
                        ],
                    ],

                    ['label' => Yii::t('AdminModule.widgets_AdminMenu', 'File Setting'), 'icon' => 'file-code-o', 'url' => ['/file/setting'],],
                    ['label' => Yii::t('AdminModule.base', 'Basic Setting'), 'icon' => 'gears', 'url' => ['/admin/index/setting'],],
                ],
            ]
        );

        parent::init();
    }
}
