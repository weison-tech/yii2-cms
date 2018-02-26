<?php

namespace core\modules\home\models;

use Yii;
use core\modules\file\behaviors\UploadBehavior;
use core\modules\file\models\File;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\modules\admin\models\Admin;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property integer $sort_order
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Link extends \yii\db\ActiveRecord
{

    /**
     * @var string the thumb input name
     */
    public $thumb;

    /**
     * Status disabled.
     */
    const STATUS_DISABLED = 0;

    /**
     * Status enabled.
     */
    const STATUS_ENABLED = 1;

    /**
     * Status deleted.
     */
    const STATUS_DELETED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'thumb'], 'required'],
            [['sort_order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 120],
            [['url'], 'string', 'max' => 255],
            [['thumb'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumb',
            ],
            [
                'class' => TimestampBehavior::class,
            ],
            [
                'class' => BlameableBehavior::class,
                'value' => Yii::$app->admin->id,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('HomeModule.models_Link', 'ID'),
            'name' => Yii::t('HomeModule.models_Link', 'Name'),
            'url' => Yii::t('HomeModule.models_Link', 'Url'),
            'thumb' => Yii::t('HomeModule.models_Link', 'Thumb'),
            'sort_order' => Yii::t('HomeModule.models_Link', 'Sort Order'),
            'status' => Yii::t('HomeModule.models_Link', 'Status'),
            'created_at' => Yii::t('base', 'Created At'),
            'created_by' => Yii::t('base', 'Created By'),
            'updated_at' => Yii::t('base', 'Updated At'),
            'updated_by' => Yii::t('base', 'Updated By'),
        ];
    }

    /**
     * Relation to image.
     * @return \yii\db\ActiveQuery
     */
    public function getImg()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'thumb']);
    }

    /**
     * Relation to creator.
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Admin::class, ['id' => 'created_by']);
    }

    /**
     * Relation to reviser.
     * @return \yii\db\ActiveQuery
     */
    public function getReviser()
    {
        return $this->hasOne(Admin::class, ['id' => 'updated_by']);
    }

    /**
     * Get the status description or status array.
     * @param bool|int $status
     * @return array|mixed
     */
    public static function getStatus($status = false)
    {
        $data = [
            self::STATUS_ENABLED => Yii::t('base', 'Enabled'),
            self::STATUS_DISABLED => Yii::t('base', 'Disabled'),
        ];
        return $status === false ? $data : $data[$status];
    }
}
