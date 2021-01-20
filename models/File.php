<?php

namespace app\models;

use app\components\fileAnalyzer\BaseFileAnalyzer;
use app\components\FileShelfModel;
use app\models\query\FileQuery;
use app\models\query\StorageQuery;
use DateTime;
use rmrevin\yii\fontawesome\FAS;
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
 *
 * @property-read mixed    $icon
 * @property-read string   $fileName
 * @property-write string  $file
 */
class File extends FileShelfModel
{

    /**
     * @var null|string The absolute path of the physical file
     */
    private $absolutePath = null;


    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
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
     */
    public function rules() : array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name', 'ext', 'sha1_checksum', 'storage_id'],
             'required',
            ],
            [['byte_size', 'image_width', 'image_height', 'date', 'last_analyzed_at', 'storage_id'],
             'integer',
            ],
            [['name', 'ext', 'mimetype', 'author', 'title', 'sub_directory'],
             'string',
             'max' => 255,
            ],
            [['sha1_checksum'],
             'string',
             'length' => 40,
            ],
            [['raw_content', 'content'],
             'string',
            ],
            [['is_content_locked'],
             'boolean',
            ],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
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


    /**
     * Runs an analysis against the current File model
     *
     * @throws \yii\base\ErrorException
     */
    public function analyze() : void
    {
        /** @var BaseFileAnalyzer $analyzerComponent */
        $analyzerComponent = Yii::$app->fileAnalyzer;

        // TODO: Handle exceptions
        $analyzer = $analyzerComponent->getAnalyzer($this);
        $analyzer->run();

        if (!$this->save()) {
            throw new ErrorException("File #" . $this->id . ": \n" . implode("\n", $this->getErrors()));
        }
    }


    /**
     * Get the Storage the current File is in
     *
     * @return ActiveQuery|StorageQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::class, ['id' => 'storage_id']);
    }


    /**
     * Get the absolute path of the physical file
     *
     * @return string
     */
    public function getAbsolutePath() : string
    {
        if ($this->absolutePath === null) {
            $this->absolutePath = FileHelper::normalizePath($this->storage->path . $this->sub_directory . '/' . $this->fileName);
        }

        return $this->absolutePath;
    }


    /**
     * Get the full file name including the extension
     *
     * @return string
     */
    public function getFileName() : string
    {
        return $this->name . '.' . $this->ext;
    }


    /**
     * Sets the text content of a file, if the content is not locked
     *
     * @param string $content
     */
    public function setContent(string $content) : void
    {
        if (!$this->is_content_locked) {
            $this->content = $content;
        }
    }


    /**
     * Sets the physical file of a model by absolute path
     *
     * @param string $absolutePath
     */
    public function setFile(string $absolutePath) : void
    {
        $filePath = FileHelper::normalizePath($absolutePath);
        $directory = str_replace($this->storage->path, '', pathinfo($filePath, PATHINFO_DIRNAME));

        $this->ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $this->name = pathinfo($filePath, PATHINFO_FILENAME);
        $this->sub_directory = $directory;
    }


    /**
     * Get the date of the file
     *
     * @return \DateTime
     */
    public function getDate() : DateTime
    {
        return DateTime::createFromFormat('U', $this->date);
    }


    /**
     * Set the date of the file
     *
     * @param int|\DateTime $date
     */
    public function setDate($date) : void
    {
        if (!is_int($date) && !($date instanceof DateTime)) {
            throw new InvalidValueException("");
        }

        if ($date instanceof DateTime) {
            $this->date = (int)$date->format('U');
        } else {
            $this->date = $date;
        }
    }
}
