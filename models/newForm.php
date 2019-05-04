<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 04.05.2019
 * Time: 16:14
 */

namespace app\models;


use yii\base\Model;

class newForm extends Model
{
    public $name;
    public $surName;
    public $document;
    public $date;


    public function rules()
    {

    }

    public function attributeLabels()
    {

    }
}