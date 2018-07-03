<?php
namespace core\modules\admin\forms;

use core\modules\admin\models\Admin;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class LoginForm extends Model
{
    /**
     * @var string username
     */
    public $username;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var bool weather to remember login.
     */
    public $rememberMe = true;

    /**
     * @var bool user
     */
    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('AdminModule.forms_LoginForm', 'Username'),
            'password' => Yii::t('AdminModule.forms_LoginForm', 'Password'),
            'rememberMe' => Yii::t('AdminModule.forms_LoginForm', 'Remember Me')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('AdminModule.forms_LoginForm', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws ForbiddenHttpException
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
        if (Yii::$app->admin->login($this->getUser(), $duration)) {
            return true;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return array(Admin object) | null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = Admin::find()
                ->andWhere(['or', ['username' => $this->username], ['email' => $this->username]])
                ->andWhere(['status' => Admin::STATUS_ACTIVE])
                ->one();
        }
        return $this->user;
    }
}
