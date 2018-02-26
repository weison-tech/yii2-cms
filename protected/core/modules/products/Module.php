<?php
namespace core\modules\products;

class Module extends \core\components\Module
{
    /**
     * @var bool whether this module is core module.
     */
    public $isCoreModule = true;

    public $controllerNamespace = 'core\modules\products\controllers';

    public $defaultRoute = 'index';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
