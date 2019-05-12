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
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (Yii::$app->user->isGuest)
            return $this->redirect('/auth/login', 302);
    }
    /**
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionStatus() //Принять и отказаться от работы  TODO:Перенести свойства delete ready в статус
    {
        $user = Users::getUserBySessionId();
        if (!$user && Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('nouser', 'Такого пользователя не существует!');
            return $this->redirect('/auth/login');
        }        if (!$user) {
            Yii::$app->session->setFlash('nouser', 'Такого пользователя не существует!');
            return $this->redirect('/tasks/view');
        }
        if ($user->is_notary != 1) {
            return $this->redirect('/tasks/index');
            //exit();
        }
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        $notary = Users::find()->andWhere(['id'=> Yii::$app->user->id])->one();

        if ($currTask->notary_id == Yii::$app->user->id) {

            if (!$currTask){
                Yii::$app->session->setFlash('notask','Данного заказа не существует!');
                return $this->redirect('clientview');
            }
            if ($currTask->is_accepted == 1) {
                $currTask->is_accepted = 0;
                $currTask->notary_id = 0;
                $currTask->notary_name = 'no notary';
                $currTask->save();
            }

        }  elseif ($currTask->is_accepted == 0 && $currTask->notary_id == 0 && $notary->is_notary == 1) {
        $currTask->is_accepted = 1;
        $currTask->notary_id = Yii::$app->user->id;
        $currTask->notary_name = Yii::$app->user->identity->login;
        $currTask->save();
    }

        return $this->redirect('/tasks/view');
    }

    public function actionClientview()
    {
        $clientTasks = WorkList::getTasksBySessionId();
        if (!$clientTasks){
            Yii::$app->session->setFlash('notask','Данного заказа не существует!');
            return $this->redirect('viewclient');
        }
        return $this->render('viewclient', ['clientTasks' => $clientTasks]);
    }

    public function actionClientstatus()
    {
        $id = Yii::$app->request->get('id');
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        if (!$currTask){
            Yii::$app->session->setFlash('notask','Данного заказа не существует!');
            return $this->redirect('clientview');
        }
        if (Yii::$app->user->id == $currTask->user_id) {
            if ($currTask->is_deleted == 0) {
                $currTask->is_deleted = 1;
                $currTask->is_accepted = 0;
                $currTask->modify_date = time();
            } elseif ($currTask->is_deleted == 1) {
                $currTask->is_deleted = 0;
                $currTask->modify_date = time();
            }
        }

        $currTask->save();
       return $this->redirect('clientview');
    }


    public function actionUploadfile()
    {
        $model = new UploadForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id = Yii::$app->request->get('id');
            $currTask = WorkList::find()->andWhere(['id' => $id])->one();
            if (!$currTask){
                Yii::$app->session->setFlash('notask','Данного заказа не существует!');
                return $this->redirect('view');
            }
            if ($currTask->notary_id == Yii::$app->user->id) {
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


                        $currTask->file_link = $link;
                        $currTask->file_key = $key;
                        $currTask->modify_date = time();
                        $currTask->save();
                        return $this->redirect('/tasks/view');
                    }
                }

            }

        }
        return $this->render('uploadfile', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionView()
    {

        $user = Users::getUserBySessionId();
        if (!$user && Yii::$app->user->isGuest)
            return $this->redirect('/auth/login');
        if(!$user)
            exit(/*'Такого пользователя не существует'*/);
        if ($user->is_notary != 1) {
            return $this->redirect('/tasks/index');
            //exit();
        }
        $allTasks = WorkList::getAllTasks();
        return $this->render('viewall', ['allTasks' => $allTasks]);
    }


    /**
     * @return \yii\web\Response
     */
    public function actionReady()
    {

        $id = Yii::$app->request->get('id');
        if (!$id){
            Yii::$app->session->setFlash('noid','Повторите попытку!');
            return $this->redirect('/tasks/view');
            }
        $currTask = WorkList::find()->andWhere(['id' => $id])->one();
        if ($currTask->notary_id == Yii::$app->user->id) {
            if ($currTask->is_ready == 0)
                $currTask->is_ready = 1;
            elseif ($currTask->is_ready == 1)
                $currTask->is_ready = 0;
            $currTask->save();
        }
        return $this->redirect('/tasks/view');
    }


    /**
     * @return string
     */
    public function actionNew()
    {

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
        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $key
     * @return $this|\yii\web\Response
     */
    public function actionDownload($key)
    {
        $saveFile = WorkList::find()->andWhere(['file_key' => $key])->one();
        if (!$saveFile)
            exit();
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

    /**
     * @param $pathToNameOfFile
     * @param $pathToTmpFile
     * @param $pathToUploadDir
     * @param $model
     */
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
            $newWork->user_id = Yii::$app->user->id;
            $newWork->name = trim($model->name);
            $newWork->sur_name = trim($model->surName);
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
            $newWork->is_ready = 0;
            $newWork->save();


        }
    }
}