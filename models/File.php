<?php

namespace app\models;

use app\components\fileAnalyzer\AbstractFileAnalyzer;
use app\components\fileAnalyzer\IFileAnalyzer;
use app\components\FileShelfModel;
use app\models\query\FileQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file".
 *
 * @property string  $name              Name
 * @property string  $ext               Extension
 * @property string  $mimetype          Mime Type
 * @property string  $raw_content       Raw content
 * @property string  $content           Content
 * @property boolean $is_content_locked Is content locked
 * @property int     $byte_size         Byte size
 * @property int     $image_width       Image width
 * @property int     $image_height      Image height
 * @property int     $last_analyzed_at  Last analyzed at
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
            [['name', 'ext', 'mimetype', 'sub_directory'], 'string', 'max' => 255],
            [['raw_content', 'content'], 'string'],
            [['is_content_locked'], 'boolean'],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'              => Yii::t('model_file', 'Name'),
            'ext'               => Yii::t('model_file', 'Extension'),
            'mimetype'          => Yii::t('model_file', 'Mime Type'),
            'sub_directory'     => Yii::t('model_file', 'Sub Directory'),
            'raw_content'       => Yii::t('model_file', 'Raw content'),
            'content'           => Yii::t('model_file', 'Content'),
            'is_content_locked' => Yii::t('model_file', 'Is content locked'),
            'byte_size'         => Yii::t('model_file', 'Byte size'),
            'image_width'       => Yii::t('model_file', 'Image width'),
            'image_height'      => Yii::t('model_file', 'Image height'),
            'last_analyzed_at'  => Yii::t('model_file', 'Last analyzed at'),
        ]);
    }


    public function analyze()
    {
        /** @var AbstractFileAnalyzer $analyzerComponent */
        $analyzerComponent = Yii::$app->fileAnalyzer;

        /** @var IFileAnalyzer $analyzer */
        $analyzer = $analyzerComponent->getAnalyzer($this);

        $this->raw_content = $analyzer->getText();

        if (!$this->is_content_locked) {
            $this->content = $this->raw_content;
        }

        if (count($this->dirtyAttributes)) {
            $this->save();
        }
    }
}
