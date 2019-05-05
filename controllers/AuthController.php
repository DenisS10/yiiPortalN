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
//        if (!Yii::$app->session->get('auth') || Yii::$app->session->get('auth') != 'ok')
//            $this->redirect('login');
//        Users::findByLogin('www');
//        exit();
//        Users::getLoginById(76);
//        Users::getPassById(76);
//        return $this->render('index', [
//            'model' => '',
//        ]);
        //$this->getUser();
        // echo Yii::$app->security->generatePasswordHash('das');
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
            if (!$user)
                exit();

            if ($user->is_notary == 1) { /* TODO: Сделать отдельный интерфейс для нотариусов */
                if (Yii::$app->security->validatePassword($model->password, $user->password))
                    Yii::$app->user->login($user);
                $this->redirect("/tasks/view");
            } else {
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
public
function actionSignup()
{

    $model = new SignupForm();

    $newUser = new Users();
    if ($model->load(Yii::$app->request->post())) {

        if ($model->validate()) {

            if ($model->password === $model->passwordReload) {


                $_password = password_hash($model->password, PASSWORD_DEFAULT);
                $newUser->login = $model->username;
                $newUser->modify_date = 0;
                $newUser->password = $_password;
                $newUser->creation_date = time();
                //$checkNotary = Yii::$app->request->post();
                $newUser->is_notary = $model->isNotary;
                $newUser->save();
                $this->refresh();
                // $newUser->errors;
            }
        }


    }
    return $this->render('signup', [
        'model' => $model,
    ]);

}

public
function actionMyaccount()
{

    // if (!Yii::$app->session->get('auth') || Yii::$app->session->get('auth') != 'ok') ;
//        if (Yii::$app->user->isGuest)
//            $this->redirect('login');

    $currUser = Users::getUserBySessionId();
    $model = new MyAccountForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        if (password_verify($model->oldPass, $currUser->password) == true) {
            if ($model->newPass === $model->repeatNewPass) {
                $_password = password_hash($model->repeatNewPass, PASSWORD_DEFAULT);
                $currUser->password = $_password;
                $currUser->save();
                //echo 'password = '.$currUser->password;
            }

        }
    }
    return $this->render('myAccount', [
        'model' => $model,
    ]);
}

public
function actionLogout()
{
//        if (Yii::$app->session->get('auth') == 'ok' || Yii::$app->session->get('auth') != 'ok')
//            $this->redirect('login');
    Yii::$app->user->logout();
    $this->redirect('login');

}
/*    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
    }

    public static function getPassById($id)
    {
        return Users::find()->andWhere(['id' => $id])->all()[0]->password;
    }
    public static function getLoginById($id)
    {
        return Users::find()->andWhere(['id' => $id])->all()[0]->login;
    }
    public static function findByLogin($login)
    {
        return Users::find()->andWhere(['login' => $login])->all()[0];
    }

    public static function getUserBySessionId()
    {
        $id = Yii::$app->session->get('id');
        return Users::find()->andWhere(['id' => $id])->one();
    }*/
}