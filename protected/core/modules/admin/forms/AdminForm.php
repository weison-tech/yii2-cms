<?php
namespace core\modules\admin\forms;

use Yii;
use yii\base\Model;
use core\modules\admin\models\Admin;

/**
 * Create admin user form
 */
class AdminForm extends Model
{
    /**
     * @var string username
     */
    public $username;

    /**
     * @var string email
     */
    public $email;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var string confirmPassword.
     */
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'core\modules\admin\models\Admin', 'message' => Yii::t('InstallerModule.forms_AdminForm', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'core\modules\admin\models\Admin', 'message' => Yii::t('InstallerModule.forms_AdminForm', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['confirmPassword', 'required'],
            ['confirmPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('InstallerModule.forms_AdminForm', 'Confirm password must as same as password.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('InstallerModule.forms_AdminForm', 'Username'),
            'password' => Yii::t('InstallerModule.forms_AdminForm', 'Password'),
            'confirmPassword' => Yii::t('InstallerModule.forms_AdminForm', 'Confirm Password'),
            'email' => Yii::t('InstallerModule.forms_AdminForm', 'Email'),
        ];
    }

    /**
     * Create admin user.
     * @return Admin | null the saved model or null if saving fails
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
        $admin = new Admin();
        $admin->username = $this->username;
        $admin->email = $this->email;
        $admin->setPassword($this->password);
        $admin->save();
        
        return $admin->save() ? $admin : null;
    }
}
