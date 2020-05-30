<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\StorageQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "storage".
 *
 * @property string      $name            Name
 * @property string      $icon            Icon
 * @property string      $path            Path
 * @property int         $storage_type_id StorageType ID
 *
 * @property StorageType $storageType
 */
class Storage extends FileShelfModel
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
        return ArrayHelper::merge(parent::rules(), [
            [['name', 'path', 'storage_type_id'], 'required'],
            [['storage_type_id'], 'integer'],
            [['name', 'icon', 'path'], 'string', 'max' => 255],
            [['storage_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => StorageType::class, 'targetAttribute' => ['storage_type_id' => 'id']],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'            => Yii::t('model_storage', 'Name'),
            'icon'            => Yii::t('model_storage', 'Icon'),
            'path'            => Yii::t('model_storage', 'Path'),
            'storage_type_id' => Yii::t('model_storage', 'StorageType ID'),
        ]);
    }


    /**
     * @return ActiveQuery|StorageQuery
     */
    public function getStorageType()
    {
        return $this->hasOne(StorageType::class, ['id' => 'storage_type_id']);
    }
}
