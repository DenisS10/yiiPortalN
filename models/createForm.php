<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 04.05.2019
 * Time: 16:14
 */

namespace app\models;


use yii\base\Model;

class createForm extends Model
{
    public $name;
    public $surName;
    public $deadline;
    public $userFile;
    public $price;
    public $needDocVerify;



    public function rules()
    {
        return[
            [['name', 'surName','deadline','price'], 'required','message' => 'Необходимо заполнить поле'],
            [['name','surName','price'],'string','max' => 50],
            [['deadline'], 'string','max' => 50],
            [['userFile'], 'file', 'skipOnEmpty' => false,'extensions' => 'PDF, pdf',],

        ];
    }

    public function attributeLabels()
    {
        return [
          'name' => 'Имя',
          'surName' => 'Фамилия',
          'deadline' => 'Крайний срок',
          'userFile' => 'Документ',
          'price' => 'Цена работы',

        ];
    }
}