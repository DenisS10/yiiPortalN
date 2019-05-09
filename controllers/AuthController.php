<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 26.04.2019
 * Time: 12:40
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\MyAccountForm;
use app\models\SignupForm;
use app\models\Users;
use Yii;
use yii\web\Controller;


class AuthController extends Controller
{
    /**
     *
     */
    public function actionIndex()
    {

    }


    /**
     * @return string
     */
    public function actionLogin()
    {
        // if (!Yii::$app->session->get('auth') || Yii::$app->session->get('auth') != 'ok')
        //$this->redirect('login');
        if (Yii::$app->user->isGuest == false)
            $this->redirect('/tasks/index');
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Users::findByLogin($model->login);

            if (!$user) {
                Yii::$app->session->setFlash('nouser', 'Такого пользователя не существует!');
                //sleep(5);
                return $this->render('login', [
                    'model' => $model,
                ]);
            }


            if ($user->is_notary == 1) { /* TODO: Сделать отдельный интерфейс для нотариусов */
                if (Yii::$app->security->validatePassword($model->password, $user->password))
                    Yii::$app->user->login($user);
                $this->redirect("/tasks/view");
            } else {
                if (Yii::$app->security->validatePassword($model->password, $user->password))
                    Yii::$app->user->login($user);
                $this->redirect("/tasks/new");
            }

        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $newUser = new Users();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                if ($model->password === $model->passwordReload) {


                    $_password = Yii::$app->security->generatePasswordHash($model->password);
                    $newUser->login = $model->username;
                    $newUser->modify_date = 0;
                    $newUser->password = $_password;
                    $newUser->creation_date = time();
                    $newUser->is_notary = $model->isNotary;
                    $newUser->save();
                    return $this->redirect('/auth/login');

                    // $newUser->errors;
                }
            }


        }
        return $this->render('signup', [
            'model' => $model,
        ]);

    }

//public
//function actionMyaccount()
//{
//
//    // if (!Yii::$app->session->get('auth') || Yii::$app->session->get('auth') != 'ok') ;
////        if (Yii::$app->user->isGuest)
////            $this->redirect('login');
//
//    $currUser = Users::getUserBySessionId();
//    $model = new MyAccountForm();
//    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//
//        if (password_verify($model->oldPass, $currUser->password) == true) {
//            if ($model->newPass === $model->repeatNewPass) {
//                $_password = password_hash($model->repeatNewPass, PASSWORD_DEFAULT);
//                $currUser->password = $_password;
//                $currUser->save();
//                //echo 'password = '.$currUser->password;
//            }
//
//        }
//    }
//    return $this->render('myAccount', [
//        'model' => $model,
//    ]);
//}

    public function actionLogout()
    {
//        if (Yii::$app->session->get('auth') == 'ok' || Yii::$app->session->get('auth') != 'ok')
//            $this->redirect('login');
        Yii::$app->user->logout();
        $this->redirect('login');

    }

}