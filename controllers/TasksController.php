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
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);

        return $this->render('index');
    }


    public function actionNew()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);


        $model = new createForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (isset($_FILES['createForm'])) {

                $name = md5(time() . rand(1, 1000) . $_FILES['createForm']['name']['userFile']);
                $key = $name[0] . $name[1] . $name[2] . $name[3] . $name[4] . $name[5] . $name[6] . $name[7];
               // Yii::$app->session->open();
                //Yii::$app->session->set('keyLink', $key);
                $ext = explode('.', $_FILES['createForm']['name']['userFile']);
                $ext = $ext[count($ext) - 1];
                $pathOld = '../uploads/' . $name[0] . '/' . $name[1] . '/';//;
                $path = str_replace('\\', '/', $pathOld);
                $link = $path . $name;
                //$this->Files->uploadFile($link, $key, $ext);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                if (!isset($_FILES['createForm']['tmp_name'])) {
                    $this->redirect('new');
                    exit();
                }
                move_uploaded_file($_FILES['createForm']['tmp_name']['userFile'],
                    $path . '/' . $name . '.' . $ext);
                if (file_exists($path)) {
                    $newWork = new WorkList();
                    $newWork->user_id = Yii::$app->session->get('__id');
                    $newWork->name = $model->name;
                    $newWork->sur_name = $model->surName;
                    $newWork->price = $model->price;
                    $newWork->creation_date = time();
                    $newWork->modify_date = 0;
                    $newWork->deadline_date = 0;
                    $newWork->file_key = $key;
                    $newWork->file_link = $link;
                    $newWork->extension = $ext;
                    $newWork->is_accepted = 0;
                    $newWork->notary_name = Yii::$app->user->identity->login;
                    $newWork->save();
                }
            }


        }

        $model->name = '';
        $model->surName = '';
        $model->deadline = '';
        $model->price = '';
        return $this->render('create', ['model' => $model]);
    }
    public function actionDownload($key)
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $saveFile = WorkList::find()->andWhere(['file_key' => $key])->one();
        if($saveFile != null) {
            $pathOld = __DIR__ . '/' . $saveFile->file_link . '.' . $saveFile->extension;
            $path = str_replace('\\', '/', $pathOld);
            if (file_exists($path))
                return Yii::$app->response->sendFile($path);
            else {
                $delNotExistsFile = WorkList::find()->andWhere(['file_key' => $key])->one();
                $delNotExistsFile->delete();
                return $this->redirect('/tasks/view');
            }
        }
    }
    public function actionView()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $allTasks = WorkList::getAllTasks();
        return $this->render('viewall', ['allTasks' => $allTasks]);
    }

    public function actionAccept()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
    }

    public function actionDeny()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
    }
}