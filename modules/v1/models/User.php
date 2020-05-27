<?php

namespace app\modules\v1\models;

use app\modules\v1\components\FileShelfModel;
use Yii;
use yii\helpers\ArrayHelper;

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
class User extends FileShelfModel
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
     * @return \app\modules\v1\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\v1\models\query\UserQuery(get_called_class());
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
            'name'          => Yii::t('user', 'Name'),
            'email'         => Yii::t('user', 'E-Mail'),
            'password_hash' => Yii::t('user', 'Password'),
            'access_token'  => Yii::t('user', 'Access Token'),
            'refresh_token' => Yii::t('user', 'Refresh Token'),
            'avatar'        => Yii::t('user', 'Avatar'),
            'formats'       => Yii::t('user', 'Formats'),
        ]);
    }

}
