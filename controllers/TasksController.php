<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 04.05.2019
 * Time: 16:10
 */

namespace app\controllers;


use app\models\newForm;
use app\models\WorkList;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionNew()
    {
        $model = new newForm();
        return $this->render('new',['model' => $model]);
    }

    public function actionView()
    {
        $allTasks = WorkList::getAllTasks();
        return $this->render('viewall',['allTasks' => $allTasks]);
    }
}