<?php

namespace app\components\fileAnalyzer;

/**
 * Interface for file analyzers
 *
 * @package app\components\fileAnalyzer
 */
interface IFileAnalyzer
{

    /**
     * Run an analysis against the current file and set the file attributes accordingly
     */
    public function run() : void;


    /**
     * Get the plain text content of the current file via parser
     *
     * @return string
     */
    public function getText() : string;
}
