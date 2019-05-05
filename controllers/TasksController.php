<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 04.05.2019
 * Time: 16:10
 */

namespace app\controllers;


use app\models\createForm;
use app\models\WorkList;
use Yii;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect('/auth/login',302);
        return $this->render('index');
    }
    public function actionNew()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect('/auth/login',302);


        $model = new createForm();

        if($model->load(Yii::$app->request->post())){

            $newWork = new WorkList();
            $newWork->user_id = Yii::$app->session->get('__id');
            $newWork->name = $model->name;
            $newWork->sur_name = $model->surName;
            $newWork->price = $model->price;
            $newWork->creation_date = time();
            $newWork->modify_date = 0;
            $newWork->deadline_date = 0;
            $newWork->file_key = 'ljklk';
            $newWork->file_link = 'asdas';
            $newWork->is_accepted = 0;
            $newWork->notary_name = Yii::$app->user->identity->login;
            $newWork->save();
            echo '<pre>';
            print_r($newWork->errors);
            exit();
            if($model->validate()) {

            }
        }
        $model->name = '';
        $model->surName = '';
        $model->deadline = '';
        $model->price = '';
        return $this->render('create',['model' => $model]);
    }

    public function actionView()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect('/auth/login',302);
        $allTasks = WorkList::getAllTasks();
        return $this->render('viewall',['allTasks' => $allTasks]);
    }

    public function actionAccept()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect('/auth/login',302);
    }
    public function actionDeny()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect('/auth/login',302);
    }
}