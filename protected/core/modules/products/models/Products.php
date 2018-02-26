<?php

namespace core\modules\products\models;

use Yii;
use core\modules\file\behaviors\UploadBehavior;
use core\modules\file\models\File;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\modules\admin\models\Admin;
use core\models\Category;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property string $id
 * @property string $category_id
 * @property string $industry_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $sort_order
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Products extends \yii\db\ActiveRecord
{

    /**
     * @var string the thumb input name
     */
    public $thumb;

    /**
     * @var string the images input name
     */
    public $images;

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
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'industry_id', 'name', 'title', 'thumb'], 'required'],
            [['category_id', 'industry_id', 'sort_order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 120],
            [['title'], 'string', 'max' => 255],
            [['thumb', 'images'], 'safe'],
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
                'attribute' => 'images',
                'multiple' => true,
            ],
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
     * Set default value
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->sort_order == null) {
            $this->sort_order = 0;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ProductsModule.models_Products', 'ID'),
            'category_id' => Yii::t('ProductsModule.models_Products', 'Category ID'),
            'industry_id' => Yii::t('ProductsModule.models_Products', 'Industry ID'),
            'name' => Yii::t('ProductsModule.models_Products', 'Name'),
            'thumb' => Yii::t('ProductsModule.models_Products', 'Thumb'),
            'images' => Yii::t('ProductsModule.models_Products', 'Images'),
            'title' => Yii::t('ProductsModule.models_Products', 'Title'),
            'description' => Yii::t('ProductsModule.models_Products', 'Description'),
            'sort_order' => Yii::t('base', 'Sort Order'),
            'status' => Yii::t('base', 'Status'),
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
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function getIndustry()
    {
        return $this->hasOne(Category::class, ['id' => 'industry_id']);
    }

    /**
     * @inheritdoc
     */
    public function getAlbum()
    {
        return $this->hasMany(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'images'])
            ->orderBy('sort asc');
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
