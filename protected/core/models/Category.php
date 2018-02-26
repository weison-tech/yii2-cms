<?php

namespace core\models;

use Yii;
use core\modules\file\behaviors\UploadBehavior;
use core\modules\file\models\File;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use core\modules\admin\models\Admin;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property string $parent_id
 * @property integer $sort_order
 * @property integer $status
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @var int , const category to product.
     */
    const TYPE_PRODUCT = 0;

    /**
     * @var int , const category to industry.
     */
    const TYPE_INDUSTRY = 1;

    /**
     * @var int , const category to news.
     */
    const TYPE_NEWS = 2;

    /**
     * @var int , const category to services.
     */
    const TYPE_SERVICES = 3;

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
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'parent_id', 'sort_order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 90],
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
            'id' => Yii::t('base', 'ID'),
            'type' => Yii::t('base', 'Type'),
            'name' => Yii::t('base', 'Name'),
            'thumb' => Yii::t('base', 'Thumb'),
            'parent_id' => Yii::t('base', 'Parent ID'),
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

    /**
     * The parent relation.
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * The parent relation.
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * Change the null value to be corresponding default value.
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->parent_id == null) {
            $this->parent_id = 0;
        }
        if ($this->sort_order == null) {
            $this->sort_order = 0;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Get all catalog order by parent/child with the space before child label
     * Usage: ArrayHelper::map(GoodsCatalog::get(0, GoodsCatalog::find()->asArray()->all()), 'id', 'label')
     * @param int $parentId parent catalog id
     * @param array $array catalog array list
     * @param int $level catalog level, will affect $repeat
     * @param int $add times of $repeat
     * @param string $repeat symbols or spaces to be added for sub catalog
     * @return array  catalog collections
     */
    static public function get($parentId = 0, $array = [], $level = 0, $add = 2, $repeat = '　')
    {
        $strRepeat = '';
        // add some spaces or symbols for non top level categories
        if ($level > 1) {
            for ($j = 0; $j < $level; $j++) {
                $strRepeat .= $repeat;
            }
        }
        $newArray = array();
        //performance is not very good here
        foreach ((array)$array as $v) {
            if ($v['parent_id'] == $parentId) {
                $item = (array)$v;
                $item['label'] = $strRepeat . (isset($v['title']) ? $v['title'] : $v['name']);
                $newArray[] = $item;
                $tempArray = self::get($v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray) {
                    $newArray = array_merge($newArray, $tempArray);
                }
            }
        }
        return $newArray;
    }
}
