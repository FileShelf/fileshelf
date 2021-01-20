<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\StorageTypeQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "storage_type".
 *
 * @property string     $name        Name
 * @property string     $icon        Icon
 * @property string     $formats     Formats
 *
 * @property Storage[]  $storages
 *
 * @property-read mixed $formatList
 */
class StorageType extends FileShelfModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return '{{%storage_type}}';
    }


    /**
     * {@inheritdoc}
     * @return StorageTypeQuery the active query used by this AR class.
     */
    public static function find() : StorageTypeQuery
    {
        return new StorageTypeQuery(static::class);
    }


    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'],
             'required',
            ],
            [['name', 'icon', 'formats'],
             'string',
             'max' => 255,
            ],
            [['formats'],
             'match',
             'pattern' => '(\*\.[a-z0-9]+)(\;\*\.[a-z0-9]+)*',
            ],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'    => Yii::t('model_storage_type', 'Name'),
            'icon'    => Yii::t('model_storage_type', 'Icon'),
            'formats' => Yii::t('model_storage_type', 'Formats'),
        ]);
    }


    /**
     * Gets all Storages, this StorageType is assigned to
     *
     * @return ActiveQuery|StorageTypeQuery
     */
    public function getStorages() : StorageTypeQuery
    {
        return $this->hasMany(Storage::class, ['storage_type_id' => 'id']);
    }


    /**
     * Get an array of all configured file extensions/formats
     *
     * @return false|string[]
     */
    public function getFormatList()
    {
        return explode(';', $this->formats);
    }

}
