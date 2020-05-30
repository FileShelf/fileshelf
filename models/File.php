<?php

namespace app\models;

use app\components\FileShelfModel;
use app\models\query\FileQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file".
 *
 * @property string $name             Name
 * @property string $ext              Extension
 * @property string $mimetype         Mime Type
 * @property string $content          Content
 * @property int    $byte_size        Byte size
 * @property int    $image_width      Image width
 * @property int    $image_height     Image height
 * @property int    $last_analyzed_at Last analyzed at
 */
class File extends FileShelfModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }


    /**
     * {@inheritdoc}
     * @return \app\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
            [['byte_size', 'image_width', 'image_height', 'last_analyzed_at'], 'integer'],
            [['name', 'ext', 'mimetype', 'content'], 'string', 'max' => 255],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'             => Yii::t('model_file', 'Name'),
            'ext'              => Yii::t('model_file', 'Extension'),
            'mimetype'         => Yii::t('model_file', 'Mime Type'),
            'content'          => Yii::t('model_file', 'Content'),
            'byte_size'        => Yii::t('model_file', 'Byte size'),
            'image_width'      => Yii::t('model_file', 'Image width'),
            'image_height'     => Yii::t('model_file', 'Image height'),
            'last_analyzed_at' => Yii::t('model_file', 'Last analyzed at'),
        ]);
    }
}
