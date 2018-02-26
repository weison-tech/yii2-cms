<?php
namespace core\modules\admin;

class Module extends \core\components\Module
{
    /**
     * @var bool whether this module is core module.
     */
    public $isCoreModule = true;

    public $controllerNamespace = 'core\modules\admin\controllers';

    public $defaultRoute = 'index';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
