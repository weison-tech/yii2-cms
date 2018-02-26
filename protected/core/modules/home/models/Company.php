<?php

namespace core\modules\home\models;

use Yii;
use core\modules\file\behaviors\UploadBehavior;
use core\modules\file\models\File;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property string $name
 * @property string $en_name
 * @property string $description
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $mobile
 * @property string $email
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @var string $logo logo input field
     */
    public $logo;

    /**
     * @var string $thumb thumb input field
     */
    public $thumb;

    /**
     * @var string $m_thumb mobile thumb input field
     */
    public $m_thumb;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'en_name', 'address', 'mobile', 'email'], 'required'],
            [['description'], 'string'],
            [['name', 'en_name'], 'string', 'max' => 90],
            [['address'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 16],

            [['email'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['logo', 'thumb', 'm_thumb'], 'safe'],
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
                'attribute' => 'logo',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumb',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'm_thumb',
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->latitude == null) {
            $this->latitude = '';
        }

        if ($this->longitude == null) {
            $this->longitude = '';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('HomeModule.models_Company', 'Name'),
            'en_name' => Yii::t('HomeModule.models_Company', 'En Name'),
            'description' => Yii::t('HomeModule.models_Company', 'Description'),
            'address' => Yii::t('HomeModule.models_Company', 'Address'),
            'latitude' => Yii::t('HomeModule.models_Company', 'Latitude'),
            'longitude' => Yii::t('HomeModule.models_Company', 'Longitude'),
            'mobile' => Yii::t('HomeModule.models_Company', 'Mobile'),
            'email' => Yii::t('HomeModule.models_Company', 'Email'),
            'thumb' => Yii::t('HomeModule.models_Company', 'Thumb'),
            'm_thumb' => Yii::t('HomeModule.models_Company', 'Mobile Thumb'),
        ];
    }

    /**
     * Relation to image.
     * @return \yii\db\ActiveQuery
     */
    public function getImg()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'logo']);
    }

    /**
     * Relation to image.
     * @return \yii\db\ActiveQuery
     */
    public function getThu()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'thumb']);
    }

    /**
     * Relation to image.
     * @return \yii\db\ActiveQuery
     */
    public function getMThu()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'm_thumb']);
    }

}
