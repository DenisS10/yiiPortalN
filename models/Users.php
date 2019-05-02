<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $login
 * @property string $password
 * @property int $creation_date
 * @property int $modify_date
 * @property int $is_notary
 *
 * @property WorkList[] $workLists
 * @property int $first_time [int(10)]
 * @property int $mod_time [int(10)]
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByLogin($login)
    {
        return Users::find()->andWhere(['login' => $login])->one();
    }
    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'creation_date', 'modify_date', 'is_notary'], 'required'],
            [['login', 'creation_date', 'modify_date', 'is_notary'], 'integer'],
            [['password'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'creation_date' => 'Creation Date',
            'modify_date' => 'Modify Date',
            'is_notary' => 'Is Notary',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkLists()
    {
        return $this->hasMany(WorkList::className(), ['user_id' => 'id']);
    }
}
