<?php

namespace core\modules\home\models;

use Yii;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property string $id
 * @property string $name
 * @property string $company
 * @property string $mobile
 * @property string $email
 * @property string $demand
 * @property string $created_at
 * @property integer $status
 */
class Contact extends \yii\db\ActiveRecord
{

    /**
     * Status disabled.
     */
    const STATUS_UNREAD = 0;

    /**
     * Status enabled.
     */
    const STATUS_READ = 1;

    /**
     * Status deleted.
     */
    const STATUS_DELETED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'company', 'mobile', 'email'], 'required'],
            [['demand'], 'string'],
            [['created_at', 'status'], 'integer'],
            [['name', 'company'], 'string', 'max' => 90],
            [['mobile'], 'string', 'max' => 16],
            ['mobile','match','pattern'=>'/^[1][34578][0-9]{9}$/'],
            [['email'], 'string', 'max' => 64],
            [['email'], 'email'],
        ];
    }

    public function beforeValidate()
    {
        $this->created_at = time();
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('HomeModule.models_Contact', 'ID'),
            'name' => Yii::t('HomeModule.models_Contact', 'Name'),
            'company' => Yii::t('HomeModule.models_Contact', 'Company'),
            'mobile' => Yii::t('HomeModule.models_Contact', 'Mobile'),
            'email' => Yii::t('HomeModule.models_Contact', 'Email'),
            'demand' => Yii::t('HomeModule.models_Contact', 'Demand'),
            'created_at' => Yii::t('HomeModule.models_Contact', 'Created At'),
            'status' => Yii::t('HomeModule.models_Contact', 'Status'),
        ];
    }

    /**
     * Get the status description or status array.
     * @param bool|int $status
     * @return array|mixed
     */
    public static function getStatus($status = false)
    {
        $data = [
            self::STATUS_READ => Yii::t('HomeModule.base', 'Read'),
            self::STATUS_UNREAD => Yii::t('HomeModule.base', 'Unread'),
        ];
        return $status === false ? $data : $data[$status];
    }
}
