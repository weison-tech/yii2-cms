<?php
namespace core\modules\news;

use Yii;

/**
 * CustomPagesEvents
 */
class Events extends \yii\base\BaseObject
{

    /**
     * Add menu item about news to Admin menu.
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('NewsModule.base', 'News Management'),
            'icon' => 'hacker-news',
            'url' => '#',
            'sortOrder' => 3,
            'items' => [
                ['label' => Yii::t('NewsModule.base', 'News Category Management'), 'icon' => 'bars', 'url' => ['/news/admin/category'],],
                ['label' => Yii::t('NewsModule.base', 'News List'), 'icon' => 'bullhorn', 'url' => ['/news/admin/news'],],
            ],
        ));
    }
}
