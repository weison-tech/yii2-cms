<?php
namespace core\modules\products;

use Yii;

/**
 * CustomPagesEvents
 */
class Events extends \yii\base\BaseObject
{

    /**
     * Add menu item about products to Admin menu.
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('ProductsModule.base', 'Products Management'),
            'icon' => 'gift',
            'url' => '#',
            'sortOrder' => 2,
            'items' => [
                ['label' => Yii::t('ProductsModule.base', 'Industry Management'), 'icon' => 'folder-open-o', 'url' => ['/products/admin/industry-category'],],
                ['label' => Yii::t('ProductsModule.base', 'Category Management'), 'icon' => 'bars', 'url' => ['/products/admin/category'],],
                ['label' => Yii::t('ProductsModule.base', 'Products Management'), 'icon' => 'beer', 'url' => ['/products/admin/products'],],
            ],
        ));
    }
}
