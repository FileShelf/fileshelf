<?php

namespace app\components\fileAnalyzer;

/**
 * Analyzer for Plain Text Documents
 */
class TextFileAnalyzer extends AbstractFileAnalyzer
{


    public function getText() : string
    {
        return file_get_contents($this->filePath);
    }


    protected function initParser() : void
    {
        $this->parser = null;
    }
}
