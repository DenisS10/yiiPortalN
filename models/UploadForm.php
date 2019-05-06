<?php
/**
 * Created by PhpStorm.
 * User: Ден
 * Date: 06.05.2019
 * Time: 18:07
 */

namespace app\models;


use yii\base\Model;

class UploadForm extends Model
{
    public $userFile;
    public function rules()
    {
        return[
            [['userFile'], 'file', 'skipOnEmpty' => true,'extensions' => 'PDF','maxFiles' => 5],

        ];
    }

    public function attributeLabels()
    {
        return [
            'userFile' => 'Документ',
        ];
    }

}