<?php

namespace app\modules\v1\models;

use app\modules\v1\models\query\StorageTypeQuery;
use Yii;

/**
 * This is the model class for table "storage_type".
 *
 * @property int       $id          ID
 * @property string    $name        Name
 * @property string    $icon        Icon
 * @property string    $formats     Formats
 * @property int       $created_by  Created by
 * @property int       $created_at  Created at
 * @property int       $modified_by Modified by
 * @property int       $modified_at Modified at
 *
 * @property Storage[] $storages
 * @property User      $createdBy
 * @property User      $modifiedBy
 */
class StorageType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%storage_type}}';
    }

    /**
     * {@inheritdoc}
     * @return StorageTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StorageTypeQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'created_at', 'modified_by', 'modified_at'], 'integer'],
            [['name', 'icon', 'formats'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['modified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modified_by' => 'id']],
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
            'icon'        => Yii::t('v1', 'Icon'),
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
    public function getStorages()
    {
        return $this->hasMany(Storage::class, ['storage_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifiedBy()
    {
        return $this->hasOne(User::class, ['id' => 'modified_by']);
    }
}
