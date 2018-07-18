<?php

namespace core\modules\admin\models;

use core\modules\file\behaviors\UploadBehavior;
use core\modules\file\models\File;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $repassword;

    public $old_password;

    public $avatar;

    const STATUS_NOT_ACTIVE = 1;

    const STATUS_ACTIVE = 2;

    const STATUS_DELETED = 3;

    public static $stat = [
        self::STATUS_NOT_ACTIVE  => '未激活',
        self::STATUS_ACTIVE => '已激活',
        self::STATUS_DELETED => '已删除',
    ];

    public $password;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'avatar',
                'multiple' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['username', 'email', 'password'],
            'create' => ['username', 'email', 'password', 'avatar', 'status'],
            'update' => ['username', 'email', 'password', 'avatar', 'status'],
            'self-update' => ['username', 'email', 'password', 'avatar', 'old_password', 'repassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',  'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['avatar'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('AdminModule.models_Admin', 'Username'),
            'password' => Yii::t('AdminModule.models_Admin', 'Password'),
            'email' => Yii::t('AdminModule.models_Admin', 'Email'),
            'avatar' => Yii::t('AdminModule.models_Admin', 'Avatar'),
            'old_password' => Yii::t('AdminModule.models_Admin', 'Old Password'),
            'repassword' => Yii::t('AdminModule.models_Admin', 'Repeat Password'),
            'status' => Yii::t('base', 'Status'),
            'created_at' => Yii::t('base', 'Created At'),
            'updated_at' => Yii::t('base', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setPassword($this->password);
        } else {
            if (isset($this->password) && $this->password != '') {
                $this->setPassword($this->password);
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //ignore the authKey
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->andWhere(['id' => $id])
            ->one();
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->andWhere(['access_token' => $token, 'status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function getAvatarImg()
    {
        return $this->hasOne(File::class, ['object_id' => 'id'])
            ->onCondition(['object_model' => self::class, 'object_field' => 'avatar']);
    }
}
