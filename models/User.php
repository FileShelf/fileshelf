<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\UserQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string      $name          Name
 * @property string      $email         E-Mail
 * @property string      $password_hash Password
 * @property string      $access_token  Access Token
 * @property string      $refresh_token Refresh Token
 * @property string      $auth_key      Authentication key
 * @property string      $avatar        Avatar
 * @property string      $formats       Formats
 *
 * @property-read string $authKey
 */
class User extends FileShelfModel implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
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
     * @return UserQuery the active query used by this AR class.
     */
    public static function find() : UserQuery
    {
        return new UserQuery(static::class);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    /**
     * Finds user by name
     *
     * @param string $name
     * @return \app\models\User|null
     */
    public static function findByName(string $name) : ?User
    {
        return static::find()->andWhere(['name' => $name])->one();
    }


    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name', 'email', 'password_hash', 'access_token', 'refresh_token', 'avatar', 'formats'], 'string', 'max' => 255],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
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
    public function getId() : int
    {
        return $this->getPrimaryKey();
    }


    /**
     * {@inheritdoc}
     */
    public function getAuthKey() : string
    {
        return $this->authKey;
    }


    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) : bool
    {
        return $this->authKey === $authKey;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function isPasswordValid(string $password) : bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
