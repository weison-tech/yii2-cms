<?php

/**
 * @link http://www.itweshare.com
 * @copyright Copyright (c) 2017 Itweshare
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "module_enabled".
 *
 * @property string $module_id
 */
class ModuleEnabled extends ActiveRecord
{

    const CACHE_ID_ALL_IDS = 'enabledModuleIds';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_enabled';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id'], 'required'],
            [['module_id'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'module_id' => 'Module ID',
        ];
    }

    /**
     * If the recorder is deleted from database, delete cache.
     */
    public function afterDelete()
    {
        Yii::$app->cache->delete(self::CACHE_ID_ALL_IDS);

        return parent::afterDelete();
    }

    /**
     * If the recorder is change in database, delete cache.
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->cache->delete(self::CACHE_ID_ALL_IDS);

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Find all enabled modules, and store them in cache
     * @return array|bool|mixed
     */
    public static function getEnabledIds()
    {
        $enabledModules = Yii::$app->cache->get(self::CACHE_ID_ALL_IDS);
        if ($enabledModules === false) {
            $enabledModules = [];
            foreach (self::find()->all() as $em) {
                $enabledModules[] = $em->module_id;
            }
            Yii::$app->cache->set(self::CACHE_ID_ALL_IDS, $enabledModules);
        }

        return $enabledModules;
    }
}
