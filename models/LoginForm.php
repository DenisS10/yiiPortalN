<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 26.04.2019
 * Time: 15:56
 */

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;



    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['login','required','message' => 'Необходимо заполнить поле',],
            //['password','string','min' => 3,'tooShort' => 'You nickname is very short'],
            ['password','required','message' => 'Необходимо заполнить поле'],
        ];
   }

    public function attributeLabels()
    {
        return [
          'login' => 'Nickname',
          'password' => 'Password',
        ];
    }



















//    /**
//     * @return array the validation rules.
//     */
//    public function rules()
//    {
//        return [
//            // username and password are both required
//            [['username', 'password'], 'required'],
//            // password is validated by validatePassword()
//            //['password', 'validate'],
//        ];
//    }
////    public function validatePassword($attribute, $params)
////    {
////        if (!$this->hasErrors()) {
////            $user = $this->getUser();
////
////            if (!$user || !$user->validate($this->password)) {
////                $this->addError($attribute, 'Incorrect username or password.');
////            }
////        }
////    }
//
//    /**
//     * @return bool|\yii\db\ActiveRecord
//     */
//    public function getUser()
//    {
//        if ($this->_user === false) {
//            $this->_user = Users::findByLogin($this->username);
//        }
//        echo '<pre>';
//        print_r(_user);
//        exit();
//        return $this->_user;
//    }
//    /**
//     * Logs in a user using the provided username and password.
//     * @return bool whether the user is logged in successfully
//     */
//    public function login()
//    {
//        if ($this->validate()) {
//            return Yii::$app->user->login($this->getUser(), /*$this->rememberMe ?*/ 3600*24*7 );
//        }
//        return false;
//    }

}