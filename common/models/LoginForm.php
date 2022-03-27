<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $phone;
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function getPeriod()
    {
        return $this->_user->period;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
        ];
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
    
            $model = $this->getUser();
            
            if($model !== null) {
                return Yii::$app->user->login($model, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByPhone($this->phone);
        }
    
        return $this->_user;
    }
}
