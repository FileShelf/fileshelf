<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\UserQuery;
use Yii;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $name          Name
 * @property string $email         E-Mail
 * @property string $password_hash Password
 * @property string $access_token  Access Token
 * @property string $refresh_token Refresh Token
 * @property string $avatar        Avatar
 * @property string $formats       Formats
 */
class User extends FileShelfModel implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->andWhere(['id' => $id])->one();
    }


    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return \app\models\User|null
     */
    public static function findByUsername($username)
    {
        return static::find()->andWhere(['username' => $username])->one();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name', 'email', 'password_hash', 'access_token', 'refresh_token', 'avatar', 'formats'], 'string', 'max' => 255],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'          => Yii::t('model_user', 'Name'),
            'email'         => Yii::t('model_user', 'E-Mail'),
            'password_hash' => Yii::t('model_user', 'Password'),
            'access_token'  => Yii::t('model_user', 'Access Token'),
            'refresh_token' => Yii::t('model_user', 'Refresh Token'),
            'avatar'        => Yii::t('model_user', 'Avatar'),
            'formats'       => Yii::t('model_user', 'Formats'),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }


    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
