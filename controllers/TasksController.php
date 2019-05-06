<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 04.05.2019
 * Time: 16:10
 */

namespace app\controllers;


use app\models\createForm;
use app\models\UploadForm;
use app\models\Users;
use app\models\WorkList;
use Yii;
use yii\web\Controller;

class TasksController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);


        return $this->render('index');
    }

    public function actionClientview()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $clientTasks = WorkList::getTasksBySessionId();
        return $this->render('viewclient', ['clientTasks' => $clientTasks]);
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        $currTask->is_deleted = 1;
        $currTask->is_accepted = 0;
        $currTask->modify_date = time();
        $currTask->save();
        $this->redirect('clientview');
    }

    public function actionUploadfile()
    {
        $model = new UploadForm();
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);



        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (isset($_FILES['UploadForm'])) {
                $pathToTmpFile = $_FILES['UploadForm']['tmp_name']['userFile'];
                $pathToNameOfFile = $_FILES['UploadForm']['name']['userFile'];
                $pathToUploadDir = '../uploads/';
                $name = md5(time() . rand(1, 1000) . $pathToNameOfFile);
                $key = $name[0] . $name[1] . $name[2] . $name[3] . $name[4] . $name[5] . $name[6] . $name[7];
                // Yii::$app->session->open();
                //Yii::$app->session->set('keyLink', $key);
                $ext = explode('.', $pathToNameOfFile);
                $ext = $ext[count($ext) - 1];
                $pathOld = $pathToUploadDir . $name[0] . '/' . $name[1] . '/';//;
                $path = str_replace('\\', '/', $pathOld);
                $link = $path . $name;
                //$this->Files->uploadFile($link, $key, $ext);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                move_uploaded_file($pathToTmpFile,
                    $path . '/' . $name . '.' . $ext);
                if (file_exists($path)) {
                    $id = Yii::$app->request->get('id');
                    $currTask = WorkList::find()->andWhere(['id' => $id])->one();
                    $currTask->file_link = $link;
                    $currTask->file_key = $key;
                    $currTask->modify_date = time();
                    $currTask->save();
                    return $this->redirect('/tasks/view');
                }

            }

        }
        return $this->render('uploadfile', ['model' => $model]);
    }

    public function actionRecover()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        $currTask->is_deleted = 0;
        $currTask->modify_date = time();
        $currTask->save();
        $this->redirect('clientview');
    }

    /**
     * @return string
     */
    public function actionView()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $user = Users::getUserBySessionId();
        if ($user->is_notary != 1) {
            return $this->redirect('/tasks/index');
            //exit();
        }
        $allTasks = WorkList::getAllTasks();
        return $this->render('viewall', ['allTasks' => $allTasks]);
    }

    public function actionAccept()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $user = Users::getUserBySessionId();
        if ($user->is_notary != 1) {
            return $this->redirect('/tasks/index');
            //exit();
        }
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        $currTask->is_accepted = 1;
        $currTask->notary_id = Yii::$app->session->get('__id');
        $currTask->notary_name = Yii::$app->user->identity->login;
        $currTask->save();
        return $this->redirect('/tasks/view');
    }

    public function actionDeny() //отказ от работы
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $user = Users::getUserBySessionId();
        if ($user->is_notary != 1) {
            return $this->redirect('/tasks/index');
            //exit();
        }
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        $currTask->is_accepted = 0;
        $currTask->notary_name = 'no notary';
        $currTask->save();
        return $this->redirect('/tasks/view');

    }

    /**
     * @return string
     */
    public function actionNew()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $model = new createForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($_FILES['createForm'])) {
                $pathToTmpFile = $_FILES['createForm']['tmp_name']['userFile'];
                $pathToNameOfFile = $_FILES['createForm']['name']['userFile'];
                $pathToUploadDir = '../uploads/';
                if (!isset($_FILES['createForm']['tmp_name'])) {
                    $this->redirect('new');
                    exit();
                }
                $this->upload($pathToNameOfFile, $pathToTmpFile, $pathToUploadDir, $model);
            }
        }
        $model->name = '';
        $model->surName = '';
        $model->deadline = '';
        $model->price = '';
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $key
     * @return $this|\yii\web\Response
     */
    public function actionDownload($key)
    {
        if (Yii::$app->user->isGuest)
            $this->redirect('/auth/login', 302);
        $saveFile = WorkList::find()->andWhere(['file_key' => $key])->one();
        if ($saveFile == null)
            exit();
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

    private function upload($pathToNameOfFile, $pathToTmpFile, $pathToUploadDir, $model)
    {
        $name = md5(time() . rand(1, 1000) . $pathToNameOfFile);
        $key = $name[0] . $name[1] . $name[2] . $name[3] . $name[4] . $name[5] . $name[6] . $name[7];
        // Yii::$app->session->open();
        //Yii::$app->session->set('keyLink', $key);
        $ext = explode('.', $pathToNameOfFile);
        $ext = $ext[count($ext) - 1];
        $pathOld = $pathToUploadDir . $name[0] . '/' . $name[1] . '/';//;
        $path = str_replace('\\', '/', $pathOld);
        $link = $path . $name;
        //$this->Files->uploadFile($link, $key, $ext);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        move_uploaded_file($pathToTmpFile,
            $path . '/' . $name . '.' . $ext);
        if (file_exists($path)) {
            $newWork = new WorkList();
            $newWork->user_id = Yii::$app->session->get('__id');
            $newWork->name = $model->name;
            $newWork->sur_name = $model->surName;
            $newWork->price = intval($model->price);
            $newWork->creation_date = time();
            $newWork->modify_date = 0;
            $newWork->deadline_date = strtotime($model->deadline);
            $newWork->file_key = $key;
            $newWork->file_link = $link;
            $newWork->extension = $ext;
            $newWork->is_accepted = 0;
            $newWork->notary_name = 'no notary';
            $newWork->notary_id = 0;
            $newWork->is_deleted = 0;
            $newWork->save();
        }
    }


}