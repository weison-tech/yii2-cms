<?php

namespace core\modules\admin\modules\rbac\models;

use Yii;
use yii\base\BaseObject;
use yii\caching\TagDependency;
use yii\helpers\VarDumper;

/**
 * Class RouteModel
 *
 * @package core\modules\admin\modules\rbac\models
 */
class RouteModel extends BaseObject
{
    /**
     * @var string cache tag
     */
    const CACHE_TAG = 'yii2mod.rbac.route';

    /**
     * @var \yii\caching\Cache
     */
    public $cache;

    /**
     * @var int cache duration
     */
    public $cacheDuration = 3600;

    /**
     * @var array list of module IDs that will be excluded
     */
    public $excludeModules = [];

    /**
     * @var \yii\rbac\ManagerInterface
     */
    protected $manager;

    /**
     * RouteModel constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->cache = Yii::$app->cache;
        $this->manager = Yii::$app->authManager;

        parent::__construct($config);
    }

    /**
     * Assign items
     *
     * @param array $routes
     *
     * @return bool
     */
    public function addNew($routes)
    {
        foreach ($routes as $route) {
            $this->manager->add($this->manager->createPermission('/' . trim($route, ' /')));
        }

        $this->invalidate();

        return true;
    }

    /**
     * Remove items
     *
     * @param array $routes
     *
     * @return bool
     */
    public function remove($routes)
    {
        foreach ($routes as $route) {
            $item = $this->manager->createPermission('/' . trim($route, '/'));
            $this->manager->remove($item);
        }
        $this->invalidate();

        return true;
    }

    /**
     * Get available and assigned routes
     *
     * @return array
     */
    public function getRoutes()
    {
        $routes = $this->getAppRoutes();
        $exists = [];

        foreach (array_keys($this->manager->getPermissions()) as $name) {
            if ($name[0] !== '/') {
                continue;
            }
            $exists[] = $name;
            unset($routes[$name]);
        }

        return [
            'available' => array_keys($routes),
            'assigned' => $exists,
        ];
    }

    /**
     * Get list of application routes
     *
     * @param string|null $module
     *
     * @return array
     */
    public function getAppRoutes($module = null)
    {
        if ($module === null) {
            $module = Yii::$app;
        } elseif (is_string($module)) {
            $module = Yii::$app->getModule($module);
        }

        $key = [__METHOD__, $module->getUniqueId()];
        $result = (($this->cache !== null) ? $this->cache->get($key) : false);

        if ($result === false) {
            $result = [];
            $this->getRouteRecursive($module, $result);
            if ($this->cache !== null) {
                $this->cache->set($key, $result, $this->cacheDuration, new TagDependency([
                    'tags' => self::CACHE_TAG,
                ]));
            }
        }

        return $result;
    }

    /**
     * Invalidate the cache
     */
    public function invalidate()
    {
        if ($this->cache !== null) {
            TagDependency::invalidate($this->cache, self::CACHE_TAG);
        }
    }

    /**
     * Get route(s) recursive
     *
     * @param \yii\base\Module $module
     * @param array $result
     */
    protected function getRouteRecursive($module, &$result)
    {
        if (!in_array($module->id, $this->excludeModules)) {
            $token = "Get Route of '" . get_class($module) . "' with id '" . $module->uniqueId . "'";
            Yii::beginProfile($token, __METHOD__);

            try {
                foreach ($module->getModules() as $id => $child) {
                    if (($child = $module->getModule($id)) !== null) {
                        $this->getRouteRecursive($child, $result);
                    }
                }

                foreach ($module->controllerMap as $id => $type) {
                    $this->getControllerActions($type, $id, $module, $result);
                }

                $namespace = trim($module->controllerNamespace, '\\') . '\\';
                $this->getControllerFiles($module, $namespace, '', $result);
                $all = '/' . ltrim($module->uniqueId . '/*', '/');
                $result[$all] = $all;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }

            Yii::endProfile($token, __METHOD__);
        }
    }

    /**
     * Get list controllers under module
     *
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     *
     * @return mixed
     */
    protected function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = Yii::getAlias('@' . str_replace('\\', '/', $namespace), false);
        $token = "Get controllers from '$path'";
        Yii::beginProfile($token, __METHOD__);

        try {
            if (!is_dir($path)) {
                return;
            }

            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file) && preg_match('%^[a-z0-9_/]+$%i', $file . '/')) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $baseName = substr(basename($file), 0, -14);
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $baseName));
                    $id = ltrim(str_replace(' ', '-', $name), '-');
                    $className = $namespace . $baseName . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }

        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list actions of controller
     *
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    protected function getControllerActions($type, $id, $module, &$result)
    {
        $token = 'Create controller with cofig=' . VarDumper::dumpAsString($type) . " and id='$id'";
        Yii::beginProfile($token, __METHOD__);

        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $all = "/{$controller->uniqueId}/*";
            $result[$all] = $all;
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }

        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get route of action
     *
     * @param \yii\base\Controller $controller
     * @param array $result all controller action
     */
    protected function getActionRoutes($controller, &$result)
    {
        $token = "Get actions of controller '" . $controller->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[$prefix . $id] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);

            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', substr($name, 6)));
                    $id = $prefix . ltrim(str_replace(' ', '-', $name), '-');
                    $result[$id] = $id;
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }
}
