<?php

namespace app\components\fileAnalyzer;

use PhpOffice\PhpWord\PhpWord;

/**
 * Analyzer for Word Documents
 *
 * @property PhpWord $parser Parser
 */
class WordFileAnalyzer extends BaseFileAnalyzer
{


    public function getText() : string
    {
        $sections = [];

        foreach ($this->parser->getSections() as $section) {

            $sections[] = $section->getDocPart();
        }

        return implode("\n", $sections);
    }


    protected function initParser() : void
    {
        $this->parser = new PhpWord();
    }
}
