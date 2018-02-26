<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\components;

use Yii;
use yii\base\Exception;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use core\components\bootstrap\ModuleAutoLoader;
use core\models\ModuleEnabled;

/**
 * ModuleManager handles all installed modules.
 */
class ModuleManager extends yii\base\Component
{

    /**
     * Create a backup on module folder deletion
     *
     * @var boolean
     */
    public $createBackup = true;

    /**
     * List of all modules
     * This also contains installed but not enabled modules.
     *
     * @var array moduleId-class pairs
     */
    protected $modules;

    /**
     * List of all enabled module ids
     *
     * @var array $enabledModules
     */
    protected $enabledModules = [];

    /**
     * List of core module classes.
     *
     * @var array the core module class names
     */
    protected $coreModules = [];

    /**
     * Module Manager init
     *
     * Loads all enabled moduleId's from database
     */
    public function init()
    {
        parent::init();

        // Either database installed and not in installed state
        if (!Yii::$app->params['databaseInstalled'] && !Yii::$app->params['installed']) {
            return;
        }

        if (Yii::$app instanceof console\Application && !Yii::$app->isDatabaseInstalled()) {
            $this->enabledModules = [];
        } else {
            $this->enabledModules = ModuleEnabled::getEnabledIds();
        }
    }

    /**
     * Registers a module to the manager
     * This is usually done by autostart.php in modules root folder.
     *
     * @param array $configs
     * @throws Exception
     */
    public function registerBulk(Array $configs)
    {
        foreach ($configs as $basePath => $config) {
            $this->register($basePath, $config);
        }
    }

    /**
     * Registers a module
     *
     * @param string $basePath the modules base path
     * @param array $config the module configuration (config.php)
     * @throws InvalidConfigException
     */
    public function register($basePath, $config = null)
    {
        //If not set mandatory config options, load config from the config.
        $config_file = $basePath . '/config.php';
        if ($config === null && is_file($config_file)) {
            $config = require($config_file);
        }

        // Check mandatory config options
        if (!isset($config['class']) || !isset($config['id'])) {
            throw new InvalidConfigException("Module configuration requires an id and class attribute!");
        }

        $isCoreModule = (isset($config['isCoreModule']) && $config['isCoreModule']);
        $isInstallerModule = (isset($config['isInstallerModule']) && $config['isInstallerModule']);

        $this->modules[$config['id']] = $config['class'];

        //If config has namespace, define the module's root directory's alias.
        if (isset($config['namespace'])) {
            Yii::setAlias('@' . str_replace('\\', '/', $config['namespace']), $basePath);
        }

        Yii::setAlias('@' . $config['id'], $basePath);


        //If application not have been installed, enable installer module.
        if (!Yii::$app->params['installed'] && $isInstallerModule) {
            $this->enabledModules[] = $config['id'];
        }

        // Not enabled and no core|installer module
        if (!$isCoreModule && !in_array($config['id'], $this->enabledModules)) {
            return;
        }

        // Handle Submodules
        if (!isset($config['modules'])) {
            $config['modules'] = array();
        }

        if ($isCoreModule) {
            $this->coreModules[] = $config['class'];
        }

        // Append URL Rules
        if (isset($config['urlManagerRules'])) {
            Yii::$app->urlManager->addRules($config['urlManagerRules'], false);
        }

        $moduleConfig = [
            'class' => $config['class'],
            'modules' => $config['modules']
        ];

        // Add config file values to module
        if (isset(Yii::$app->modules[$config['id']]) && is_array(Yii::$app->modules[$config['id']])) {
            $moduleConfig = ArrayHelper::merge($moduleConfig, Yii::$app->modules[$config['id']]);
        }

        // Register Yii Module
        Yii::$app->setModule($config['id'], $moduleConfig);

        // Register Event Handlers
        if (isset($config['events'])) {
            foreach ($config['events'] as $event) {
                if (isset($event['class'])) {
                    Event::on($event['class'], $event['event'], $event['callback']);
                } else {
                    Event::on($event[0], $event[1], $event[2]);
                }
            }
        }
    }

    /**
     * Returns all modules (also disabled modules).
     *
     * Note: Only modules which extends \core\components\Module will be returned.
     *
     * @param array $options options (name => config)
     * The following options are available:
     *
     * - includeCoreModules: boolean, return also core modules (default: false)
     * - returnClass: boolean, return class name instead of module object (default: false)
     *
     * @return array
     */
    public function getModules($options = [])
    {
        $modules = [];

        foreach ($this->modules as $id => $class) {

            // Skip core modules
            if (!isset($options['includeCoreModules']) || $options['includeCoreModules'] === false) {
                if (in_array($class, $this->coreModules)) {
                    continue;
                }
            }

            if (isset($options['returnClass']) && $options['returnClass']) {
                $modules[$id] = $class;
            } else {
                $module = $this->getModule($id);
                if ($module instanceof Module) {
                    $modules[$id] = $module;
                }
            }
        }

        return $modules;
    }

    /**
     * Checks if a moduleId exists, regardless it's activated or not
     *
     * @param string $id
     * @return boolean
     */
    public function hasModule($id)
    {
        return (array_key_exists($id, $this->modules));
    }

    /**
     * Returns a module instance by id
     * @param string $id Module Id
     * @return object
     * @throws Exception
     */
    public function getModule($id)
    {
        // Enabled Module
        if (Yii::$app->hasModule($id)) {
            return Yii::$app->getModule($id, true);
        }

        // Disabled Module
        if (isset($this->modules[$id])) {
            $class = $this->modules[$id];
            return Yii::createObject($class, [$id, Yii::$app]);
        }

        throw new Exception("Could not find/load requested module: " . $id);
    }

    /**
     * Flushes module manager cache
     */
    public function flushCache()
    {
        Yii::$app->cache->delete(ModuleAutoLoader::CACHE_ID);
    }

    /**
     * Checks the module can removed
     *
     * @param string $moduleId
     * @return boolean
     */
    public function canRemoveModule($moduleId)
    {
        $module = $this->getModule($moduleId);

        if ($module === null) {
            return false;
        }

        // Check is in dynamic/marketplace module folder
        if (strpos($module->getBasePath(), Yii::getAlias(Yii::$app->params['moduleMarketplacePath'])) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Removes a module
     *
     * @param string $moduleId the module id
     * @param boolean $disableBeforeRemove
     * @throws Exception
     */
    public function removeModule($moduleId, $disableBeforeRemove = true)
    {
        $module = $this->getModule($moduleId);

        if ($module == null) {
            throw new Exception("Could not load module to remove!");
        }

        /**
         * Disable Module
         */
        if ($disableBeforeRemove && Yii::$app->hasModule($moduleId)) {
            $module->disable();
        }

        /**
         * Remove Folder
         */
        if ($this->createBackup) {
            $moduleBackupFolder = Yii::getAlias("@runtime/module_backups");
            if (!is_dir($moduleBackupFolder)) {
                if (!@mkdir($moduleBackupFolder)) {
                    throw new Exception("Could not create module backup folder!");
                }
            }

            $backupFolderName = $moduleBackupFolder . DIRECTORY_SEPARATOR . $moduleId . "_" . time();
            $moduleBasePath = $module->getBasePath();
            FileHelper::copyDirectory($moduleBasePath, $backupFolderName);
            FileHelper::removeDirectory($moduleBasePath);
        } else {
            //TODO: Delete directory
        }

        $this->flushCache();
    }

    /**
     * Enables a module
     * @param \core\components\Module $module
     */
    public function enable(Module $module)
    {
        $moduleEnabled = ModuleEnabled::findOne(['module_id' => $module->id]);
        if ($moduleEnabled == null) {
            $moduleEnabled = new ModuleEnabled();
            $moduleEnabled->module_id = $module->id;
            $moduleEnabled->save();
        }

        $this->enabledModules[] = $module->id;
        $this->register($module->getBasePath());
    }

    /**
     * Batch enable module
     * @param array $modules
     */
    public function enableModules($modules = [])
    {
        foreach ($modules as $module) {
            $module = ($module instanceof Module) ? $module : $this->getModule($module);
            if ($module != null) {
                $module->enable();
            }
        }
    }

    /**
     * Disables a module
     * @param \core\components\Module $module
     */
    public function disable(Module $module)
    {
        //Delete the enabled module in database.
        $moduleEnabled = ModuleEnabled::findOne(['module_id' => $module->id]);
        if ($moduleEnabled != null) {
            $moduleEnabled->delete();
        }

        //Unset the disabled module in components's enabledModule array.
        if (($key = array_search($module->id, $this->enabledModules)) !== false) {
            unset($this->enabledModules[$key]);
        }

        //Delete module in application.
        Yii::$app->setModule($module->id, null);
    }

    /**
     * Batch disable modules
     * @param array $modules
     */
    public function disableModules($modules = [])
    {
        foreach ($modules as $module) {
            $module = ($module instanceof Module) ? $module : $this->getModule($module);
            if($module != null) {
                $module->disable();
            }
        }
    }

}
