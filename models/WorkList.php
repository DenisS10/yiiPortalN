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
 * @property int $creation_date
 * @property int $modify_date
 * @property string $doc_not_verify
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
            [['user_id', 'file_key', 'file_link', 'creation_date', 'modify_date', 'doc_not_verify'], 'required'],
            [['user_id', 'creation_date', 'modify_date'], 'integer'],
            [['file_key'], 'string', 'max' => 10],
            [['file_link'], 'string', 'max' => 250],
            [['doc_not_verify'], 'string', 'max' => 1000],
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
            'creation_date' => 'Creation Date',
            'modify_date' => 'Modify Date',
            'doc_not_verify' => 'Doc Not Verify',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
