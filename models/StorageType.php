<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\StorageTypeQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "storage_type".
 *
 * @property string    $name        Name
 * @property string    $icon        Icon
 * @property string    $formats     Formats
 *
 * @property Storage[] $storages
 */
class StorageType extends FileShelfModel
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
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
            [['name', 'icon', 'formats'], 'string', 'max' => 255],
            [['formats'], 'match', 'pattern' => '(\*\.[a-z0-9]+)(\;\*\.[a-z0-9]+)*'],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'    => Yii::t('model_storage_type', 'Name'),
            'icon'    => Yii::t('model_storage_type', 'Icon'),
            'formats' => Yii::t('model_storage_type', 'Formats'),
        ]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorages()
    {
        return $this->hasMany(Storage::class, ['storage_type_id' => 'id']);
    }


    public function getFormatList()
    {
        return explode(';', $this->formats);
    }

}
