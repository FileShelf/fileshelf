<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int           $id          ID
 * @property string        $name        Name
 * @property string        $avatar      Icon
 * @property string        $formats     Formats
 * @property int           $created_by  Created by
 * @property int           $created_at  Created at
 * @property int           $modified_by Modified by
 * @property int           $modified_at Modified at
 *
 * @property Storage[]     $ownStorages
 * @property StorageType[] $ownStorageTypes
 */
class User extends \yii\db\ActiveRecord
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
        return [
            [['created_by', 'created_at', 'modified_by', 'modified_at'], 'integer'],
            [['name', 'avatar', 'formats'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('v1', 'ID'),
            'name'        => Yii::t('v1', 'Name'),
            'avatar'      => Yii::t('v1', 'Icon'),
            'formats'     => Yii::t('v1', 'Formats'),
            'created_by'  => Yii::t('v1', 'Created by'),
            'created_at'  => Yii::t('v1', 'Created at'),
            'modified_by' => Yii::t('v1', 'Modified by'),
            'modified_at' => Yii::t('v1', 'Modified at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnStorages()
    {
        return $this->hasMany(Storage::class, ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnStorageTypes()
    {
        return $this->hasMany(StorageType::class, ['created_by' => 'id']);
    }
}
