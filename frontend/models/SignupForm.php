<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;
    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
    
            //['password', 'required'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
            'username' => 'Имя',
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        if($model = User::findOne(['phone' => $this->phone])) {
            
            return ['create_user' => false];
            
        }
        
        $user = new User();
        $user->phone = $this->phone;
        $user->username = $this->username;
        $this->password = $user->password = $user->generatePassword();
        $date = date("Y-m-d H:i:s");
        $period = strtotime($date . " + 2 day");
        $user->period = $period;
        $user->save();
        
        return ['create_user' => true];
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
