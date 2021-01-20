<?php

namespace app\components\fileAnalyzer;

use PhpOffice\PhpWord\IOFactory;

/**
 * Analyzer for Word Documents
 *
 * @package app\components\fileAnalyzer
 */
class WordFileAnalyzer extends BaseFileAnalyzer
{


    /**
     * {@inheritDoc}
     */
    public function getText() : string
    {
        $sections = [];

        foreach ($this->parser->getSections() as $section) {

            $sections[] = $section->getDocPart();
        }

        return implode("\n", $sections);
    }


    /**
     * {@inheritDoc}
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function initParser() : void
    {
        $reader = IOFactory::createReader();
        $this->parser = $reader->load($this->file->absolutePath);
    }
}
