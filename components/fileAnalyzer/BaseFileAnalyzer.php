<?php

namespace app\components\fileAnalyzer;

use app\models\File;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

/**
 *
 * @property-read string $text
 */
class BaseFileAnalyzer extends Component implements IFileAnalyzer
{

    protected $filePath;
    protected $parser;


    public function getAnalyzer(File $file) : IFileAnalyzer
    {
        $analyzer = null;

        switch ($file->ext) {
            case 'pdf':
                $analyzer = new PDFFileAnalyzer(['filePath' => $file->absolutePath]);
                break;
            case 'doc':
            case 'docx':
                $analyzer = new WordFileAnalyzer(['filePath' => $file->absolutePath]);
                break;
            default:
                $analyzer = new TextFileAnalyzer(['filePath' => $file->absolutePath]);
        }

        $analyzer->initParser();
        return $analyzer;
    }


    public function run(File $file)
    {
        $file->raw_content = $this->getText();
        $file->content = $file->raw_content;
        $file->mimetype = FileHelper::getMimeType($file->absolutePath);
        $file->byte_size = filesize($file->absolutePath);
        $file->sha1_checksum = sha1_file($file->absolutePath);

        $fileNameParts = $this->parseFileName($file->name);
        $file->author = $fileNameParts['author'];
        $file->title = $fileNameParts['title'];
        $file->date = $fileNameParts['date'];

        $file->last_analyzed_at = time();
    }


    public function getText() : string
    {
        throw new InvalidConfigException("Method `getText` must be implemented by child class");
    }


    protected function parseFileName(string $fileName) : array
    {
        $matches = [];
        $result = [
            'author' => null,
            'title'  => null,
            'date'   => 0,
        ];
        $pattern = "/^(.+?(?=\s\-\s))(\s\-\s(.*))?(\s\-\s(([12]\d{3})-?(0[1-9]|1[0-2])-?(0[1-9]|[12]\d|3[01])))$/";
        $cleanName = str_replace("_", " ", $fileName);

        if (preg_match($pattern, $cleanName, $matches, PREG_UNMATCHED_AS_NULL)) {
            $result['author'] = $matches[3] == null ? null : trim($matches[1]);
            $result['title'] = $matches[3] == null ? trim($matches[1]) : trim($matches[3]);
            $result['date'] = $matches[5] == null ? 0 : mktime(0, 0, 0, $matches[7], $matches[8], $matches[6]);
        } else {
            $result['title'] = $cleanName;
        }

        return $result;
    }


    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath) : void
    {
        $this->filePath = $filePath;
    }


    protected function initParser() : void
    {
        throw new InvalidConfigException("Method `initParser` must be implemented by child class");
    }
}
