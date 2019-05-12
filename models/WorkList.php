<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "work_list".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_key
 * @property string $file_link
 * @property string $name
 * @property string $sur_name
 * @property int $price
 * @property int $creation_date
 * @property int $modify_date
 * @property int $deadline_date
 * @property string $notary_name
 * @property int $is_accepted
 * @property string $extension
 * @property int $is_deleted
 * @property int $notary_id
 * @property int $is_ready
 *
 * @property Users $user
 */
class WorkList extends ActiveRecord
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
            [['user_id', 'file_key', 'file_link', 'name', 'sur_name', 'price', 'creation_date', 'modify_date', 'deadline_date', 'notary_name', 'is_accepted', 'extension', 'is_deleted', 'notary_id', 'is_ready'], 'required'],
            [['user_id', 'price', 'creation_date', 'modify_date', 'deadline_date', 'is_accepted', 'is_deleted', 'notary_id', 'is_ready'], 'integer'],
            [['file_key', 'extension'], 'string', 'max' => 10],
            [['file_link'], 'string', 'max' => 250],
            [['name', 'sur_name', 'notary_name'], 'string', 'max' => 50],
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
            'extension' => 'Extension',
            'is_deleted' => 'Is Deleted',
            'notary_id' => 'Notary ID',
            'is_ready' => 'Is Ready',
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

    public static function getTasksBySessionId()
    {
        $id = Yii::$app->session->get('__id');
        return WorkList::find()->andWhere(['user_id' => $id])->all();
    }
}
