<?php

namespace app\components\fileAnalyzer;

use Smalot\PdfParser\Parser;

/**
 * Analyzer for PDF Documents
 *
 * @package app\components\fileAnalyzer
 */
class PDFFileAnalyzer extends BaseFileAnalyzer
{


    /**
     * {@inheritDoc}
     */
    public function getText() : string
    {
        $pdf = $this->parser->parseFile($this->file->absolutePath);
        return $pdf->getText();
    }


    /**
     * {@inheritDoc}
     */
    protected function initParser() : void
    {
        $this->parser = new Parser();
    }
}
