<?php
namespace core\modules\home;

use Yii;

/**
 * CustomPagesEvents
 */
class Events extends \yii\base\BaseObject
{

    /**
     * Add menu item about home to Admin menu.
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('HomeModule.base', 'Basic Setting'),
            'icon' => 'home',
            'url' => '#',
            'sortOrder' => 1,
            'items' => [
                ['label' => Yii::t('HomeModule.base', 'Company Info'), 'icon' => 'bank', 'url' => ['/home/admin/company'],],
                ['label' => Yii::t('HomeModule.base', 'Banner Management'), 'icon' => 'image', 'url' => ['/home/admin/banner'],],
                ['label' => Yii::t('HomeModule.base', 'Partner Management'), 'icon' => 'group', 'url' => ['/home/admin/partner'],],
                ['label' => Yii::t('HomeModule.base', 'Link Management'), 'icon' => 'link', 'url' => ['/home/admin/link'],],
                ['label' => Yii::t('HomeModule.base', 'Contact Management'), 'icon' => 'comments-o', 'url' => ['/home/admin/contact'],],
                ['label' => Yii::t('HomeModule.base', 'Services Management'), 'icon' => 'cloud', 'url' => ['/home/admin/services'],],
            ],
        ));
    }
}
