<?php

namespace app\models;

use app\components\fileAnalyzer\BaseFileAnalyzer;
use app\components\FileShelfModel;
use app\models\query\FileQuery;
use app\models\query\StorageQuery;
use DateTime;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidValueException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "file".
 *
 * @property string        $name              Name
 * @property string        $ext               Extension
 * @property string        $sub_directory     Sub-directory
 * @property string        $mimetype          Mime Type
 * @property string        $sha1_checksum     SHA1 checksum
 * @property string        $raw_content       Raw content
 * @property string        $content           Content
 * @property string        $title             Title
 * @property string        $author            Author
 * @property int|\DateTime $date              Date
 * @property boolean       $is_content_locked Is content locked
 * @property int           $byte_size         Byte size
 * @property int           $image_width       Image width
 * @property int           $image_height      Image height
 * @property int           $last_analyzed_at  Last analyzed at
 * @property int           $storage_id        Storage ID
 *
 * @property string        $absolutePath
 * @property Storage       $storage
 */
class File extends FileShelfModel
{

    private $absolutePath = null;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }


    /**
     * @param string $checksum
     * @return File|null
     */
    public static function findByChecksum(string $checksum) : ?File
    {
        return self::find()->where(['sha1_checksum' => $checksum])->one();
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
            [['name', 'ext', 'sha1_checksum', 'storage_id'], 'required'],
            [['byte_size', 'image_width', 'image_height', 'date', 'last_analyzed_at', 'storage_id'], 'integer'],
            [['name', 'ext', 'mimetype', 'author', 'title', 'sub_directory'], 'string', 'max' => 255],
            [['sha1_checksum'], 'string', 'length' => 40],
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
            'sha1_checksum'     => Yii::t('model_file', 'SHA1 checksum'),
            'raw_content'       => Yii::t('model_file', 'Raw content'),
            'content'           => Yii::t('model_file', 'Content'),
            'author'            => Yii::t('model_file', 'Author'),
            'title'             => Yii::t('model_file', 'Title'),
            'date'              => Yii::t('model_file', 'Date'),
            'is_content_locked' => Yii::t('model_file', 'Is content locked'),
            'byte_size'         => Yii::t('model_file', 'Byte size'),
            'image_width'       => Yii::t('model_file', 'Image width'),
            'image_height'      => Yii::t('model_file', 'Image height'),
            'last_analyzed_at'  => Yii::t('model_file', 'Last analyzed at'),
            'storage_id'        => Yii::t('model_file', 'Storage'),
        ]);
    }


    public function analyze()
    {
        /** @var BaseFileAnalyzer $analyzerComponent */
        $analyzerComponent = Yii::$app->fileAnalyzer;
        $analyzer = $analyzerComponent->getAnalyzer($this);

        $analyzer->run($this);

        if (!$this->save()) {
            throw new ErrorException("File #" . $this->id . ": \n" . implode("\n", $this->getErrors()));
        }
    }


    /**
     * @return ActiveQuery|StorageQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::class, ['id' => 'storage_id']);
    }


    public function getAbsolutePath() : string
    {
        if ($this->absolutePath === null) {
            $this->absolutePath = FileHelper::normalizePath($this->storage->path . $this->sub_directory . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext);
        }

        return $this->absolutePath;
    }


    public function getFileName() : string
    {
        return $this->name . '.' . $this->ext;
    }


    public function setContent(string $content)
    {
        if (!$this->is_content_locked) {
            $this->content = $content;
        }
    }


    public function setFile(string $absolutePath)
    {
        $filePath = FileHelper::normalizePath($absolutePath);
        $directory = str_replace($this->storage->path, '', pathinfo($filePath, PATHINFO_DIRNAME));

        $this->ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $this->name = pathinfo($filePath, PATHINFO_FILENAME);
        $this->sub_directory = $directory;
    }


    public function getDate() : DateTime
    {
        return DateTime::createFromFormat('U', $this->date);
    }


    /**
     *
     *
     * @param int|\DateTime $date
     */
    public function setDate($date)
    {
        if (!is_int($date) && !($date instanceof DateTime)) {
            throw new InvalidValueException("");
        }

        if ($date instanceof DateTime) {
            $this->date = intval($date->format('U'));
        } else {
            $this->date = $date;
        }
    }
}
