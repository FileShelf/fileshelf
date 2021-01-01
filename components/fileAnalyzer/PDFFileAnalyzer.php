<?php

namespace app\components\fileAnalyzer;

use Smalot\PdfParser\Parser;

/**
 * Analyzer for PDF Documents
 *
 * @property Parser $parser Parser
 */
class PDFFileAnalyzer extends BaseFileAnalyzer
{


    public function getText() : string
    {
        $pdf = $this->parser->parseFile($this->filePath);
        return $pdf->getText();
    }


    protected function initParser() : void
    {
        $this->parser = new Parser();
    }
}
