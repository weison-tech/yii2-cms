<?php

namespace core\modules\admin\modules\rbac\filters;

use Yii;
use yii\base\Action;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class AccessControl
 *
 * @package core\modules\admin\modules\rbac\filters
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var array list of actions that not need to check access
     */
    public $allowActions = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $controller = $action->controller;
        $params = ArrayHelper::getValue($this->params, $action->id, []);

            if (Yii::$app->admin->can('/' . $action->getUniqueId(), $params)) {
                return true;
            }

            do {
                if (Yii::$app->admin->can('/' . ltrim($controller->getUniqueId() . '/*', '/'))) {
                    return true;
                }
                $controller = $controller->module;
            } while ($controller !== null);

            return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    protected function isActive($action)
    {
        if ($this->isErrorPage($action) || $this->isLoginPage($action) || $this->isAllowedAction($action)) {
            return false;
        }

        return parent::isActive($action);
    }

    /**
     * Returns a value indicating whether a current url equals `errorAction` property of the ErrorHandler component
     *
     * @param Action $action
     *
     * @return bool
     */
    private function isErrorPage($action)
    {
        if ($action->getUniqueId() === Yii::$app->getErrorHandler()->errorAction) {
            return true;
        }

        return false;
    }

    /**
     * Returns a value indicating whether a current url equals `loginUrl` property of the User component
     *
     * @param Action $action
     *
     * @return bool
     */
    private function isLoginPage($action)
    {
        $loginUrl = trim(Url::to(Yii::$app->admin->loginUrl), '/');

        if (Yii::$app->admin->isGuest && $action->getUniqueId() === $loginUrl) {
            return true;
        }

        return false;
    }

    /**
     * Returns a value indicating whether a current url exists in the `allowActions` list.
     *
     * @param Action $action
     *
     * @return bool
     */
    private function isAllowedAction($action)
    {
        if ($this->owner instanceof Module) {
            $ownerId = $this->owner->getUniqueId();
            $id = $action->getUniqueId();
            if (!empty($ownerId) && strpos($id, $ownerId . '/') === 0) {
                $id = substr($id, strlen($ownerId) + 1);
            }
        } else {
            $id = $action->getUniqueId();
        }

        foreach ($this->allowActions as $route) {
            if (substr($route, -1) === '*') {
                $route = rtrim($route, '*');
                if ($route === '' || strpos($id, $route) === 0) {
                    return true;
                }
            } else {
                if ($id === $route) {
                    return true;
                }
            }
        }

        return false;
    }
}
