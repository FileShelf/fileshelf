<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "storage".
 *
 * @property int         $id              ID
 * @property string      $name            Name
 * @property string      $icon            Icon
 * @property string      $path            Path
 * @property int         $storage_type_id StorageType ID
 * @property int         $created_by      Created by
 * @property int         $created_at      Created at
 * @property int         $modified_by     Modified by
 * @property int         $modified_at     Modified at
 *
 * @property StorageType $storageType
 * @property User        $createdBy
 * @property User        $modifiedBy
 */
class Storage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%storage}}';
    }

    /**
     * {@inheritdoc}
     * @return StorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StorageQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'storage_type_id'], 'required'],
            [['storage_type_id', 'created_by', 'created_at', 'modified_by', 'modified_at'], 'integer'],
            [['name', 'icon', 'path'], 'string', 'max' => 255],
            [['storage_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StorageType::class, 'targetAttribute' => ['storage_type_id' => 'id']],
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
            'id'              => Yii::t('v1', 'ID'),
            'name'            => Yii::t('v1', 'Name'),
            'icon'            => Yii::t('v1', 'Icon'),
            'path'            => Yii::t('v1', 'Path'),
            'storage_type_id' => Yii::t('v1', 'StorageType ID'),
            'created_by'      => Yii::t('v1', 'Created by'),
            'created_at'      => Yii::t('v1', 'Created at'),
            'modified_by'     => Yii::t('v1', 'Modified by'),
            'modified_at'     => Yii::t('v1', 'Modified at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorageType()
    {
        return $this->hasOne(StorageType::class, ['id' => 'storage_type_id']);
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
