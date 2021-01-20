<?php

namespace app\components\fileAnalyzer;

/**
 * Analyzer for Plain Text Documents
 *
 * @package app\components\fileAnalyzer
 */
class TextFileAnalyzer extends BaseFileAnalyzer
{


    /**
     * {@inheritDoc}
     */
    public function getText() : string
    {
        return file_get_contents($this->file->absolutePath);
    }


    /**
     * {@inheritDoc}
     */
    protected function initParser() : void
    {
        $this->parser = null;
    }
}
