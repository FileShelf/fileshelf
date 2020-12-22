<?php

namespace app\components\fileAnalyzer;

use app\models\File;
use yii\base\Component;
use yii\base\InvalidConfigException;

abstract class AbstractFileAnalyzer extends Component implements IFileAnalyzer
{

    protected $filePath;
    protected $parser;


    public function init()
    {
        parent::init();

        $this->initParser();
    }


    protected function initParser() : void
    {
        throw new InvalidConfigException("Method `initParser must be implemented`");
    }


    public function getAnalyzer(File $file) : IFileAnalyzer
    {
        $analyzer = null;

        switch ($file->ext) {
            case 'pdf':
                $analyzer = new PDFFileAnalyzer(['filePath' => $this->filePath]);
                break;
            case 'doc':
            case 'docx':
                $analyzer = new WordFileAnalyzer(['filePath' => $this->filePath]);
                break;
            default:
                $analyzer = new TextFileAnalyzer(['filePath' => $this->filePath]);
        }

        return $analyzer;
    }

}
