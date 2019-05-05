<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_list".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_key
 * @property string $file_link
 * @property string $name
 * @property string $sur_name
 * @property string $price
 * @property int $creation_date
 * @property int $modify_date
 * @property int $deadline_date
 * @property string $notary_name
 * @property int $is_accepted
 *
 * @property Users $user
 */
class WorkList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file_key', 'file_link', 'name', 'sur_name', 'price', 'creation_date', 'modify_date', 'deadline_date', 'notary_name', 'is_accepted'], 'required'],
            [['user_id', 'creation_date', 'modify_date', 'deadline_date', 'is_accepted'], 'integer'],
            [['file_key'], 'string', 'max' => 10],
            [['file_link'], 'string', 'max' => 250],
            [['name', 'sur_name', 'price', 'notary_name'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file_key' => 'File Key',
            'file_link' => 'File Link',
            'name' => 'Name',
            'sur_name' => 'Sur Name',
            'price' => 'Price',
            'creation_date' => 'Creation Date',
            'modify_date' => 'Modify Date',
            'deadline_date' => 'Deadline Date',
            'notary_name' => 'Notary Name',
            'is_accepted' => 'Is Accepted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public static function getAllTasks()
    {
        return WorkList::find()->all();
    }
}
