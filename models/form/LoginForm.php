<?php

namespace app\models\form;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $userName;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules() : array
    {
        return [
            // username and password are both required
            [['userName', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string     $attribute the attribute currently being validated
     * @param array|null $params    the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, ?array $params) : void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->isPasswordValid($this->password)) {
                $this->addError($attribute, 'Incorrect userName or password.');
            }
        }
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() : ?User
    {
        if ($this->_user === false) {
            $this->_user = User::findByName($this->userName);
        }

        return $this->_user;
    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() : bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
}
