<?php

namespace app\components\fileAnalyzer;

use app\models\File;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

/**
 * Base class for file analyzers
 *
 * @package app\components\fileAnalyzer
 *
 * @property-read string $text
 */
class BaseFileAnalyzer extends Component implements IFileAnalyzer
{

    /**
     * @var File the current file
     */
    protected $file;

    /**
     * @var Object the file parser, depending on the file type
     */
    protected $parser;


    /**
     * Get the analyzer based on the extension of the given File object
     *
     * @param \app\models\File $file
     * @return \app\components\fileAnalyzer\IFileAnalyzer
     * @throws \yii\base\InvalidConfigException|\PhpOffice\PhpWord\Exception\Exception
     */
    public function getAnalyzer(File $file) : IFileAnalyzer
    {
        $analyzer = null;

        switch ($file->ext) {
            case 'pdf':
                $analyzer = new PDFFileAnalyzer(['file' => $file]);
                break;
            case 'doc':
            case 'docx':
                $analyzer = new WordFileAnalyzer(['file' => $file]);
                break;
            default:
                $analyzer = new TextFileAnalyzer(['file' => $file]);
        }

        $analyzer->initParser();
        return $analyzer;
    }


    /**
     * {@inheritDoc}
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function run() : void
    {
        $this->file->raw_content = $this->getText();
        $this->file->content = $this->file->raw_content;
        $this->file->mimetype = FileHelper::getMimeType($this->file->absolutePath);
        $this->file->byte_size = filesize($this->file->absolutePath);
        $this->file->sha1_checksum = sha1_file($this->file->absolutePath);

        $fileNameParts = $this->parseFileName($this->file->name);
        $this->file->author = $fileNameParts['author'];
        $this->file->title = $fileNameParts['title'];
        $this->file->date = $fileNameParts['date'];

        $this->file->last_analyzed_at = time();
    }


    /**
     * {@inheritDoc}
     *
     * @throws \yii\base\InvalidConfigException when not implemented by child class
     */
    public function getText() : string
    {
        throw new InvalidConfigException("Method `getText` must be implemented by child class");
    }


    /**
     * Parses the current file's name to retrieve additional meta data
     *
     * The RegEx pattern matches the following file name formats:
     * "Some Title"
     * "Some Title - YYYYMMDD"
     * "Some Title - YYYY-MM-DD"
     * "Some Author - Some Title"
     * "Some Author - Some Title - YYYYMMDD"
     * "Some Author - Some Title - YYYY-MM-DD"
     *
     * All Spaces ` ` and Underscores `_` get replaced with single spaces and trimmed before matching.
     * If no matches found, the filename will be set as title.
     *
     * @param string $fileName the bare file name without extension
     * @return array an array with the extracted meta data
     */
    protected function parseFileName(string $fileName) : array
    {
        $matches = [];
        $result = [
            'author' => null,
            'title'  => null,
            'date'   => 0,
        ];
        $pattern = "/^(.+?(?=\s\-\s))(\s\-\s(.*))?(\s\-\s(([12]\d{3})-?(0[1-9]|1[0-2])-?(0[1-9]|[12]\d|3[01])))$/";
        $cleanName = trim(preg_replace('/[\s_]+/', ' ', $fileName));

        if (preg_match($pattern, $cleanName, $matches, PREG_UNMATCHED_AS_NULL)) {
            $result['author'] = $matches[3] === null ? null : trim($matches[1]);
            $result['title'] = $matches[3] === null ? trim($matches[1]) : trim($matches[3]);
            $result['date'] = $matches[5] === null ? 0 : mktime(0, 0, 0, $matches[7], $matches[8], $matches[6]);
        } else {
            $result['title'] = $cleanName;
        }

        return $result;
    }


    /**
     * Setter for the protected file property
     *
     * @param File $file
     */
    public function setFile(File $file) : void
    {
        $this->file = $file;
    }


    /**
     * Initializes the based on the extension of the given File object
     *
     * @throws \yii\base\InvalidConfigException when not implemented by child class
     */
    protected function initParser() : void
    {
        throw new InvalidConfigException("Method `initParser` must be implemented by child class");
    }
}
