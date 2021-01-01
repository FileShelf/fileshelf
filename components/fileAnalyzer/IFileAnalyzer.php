<?php

namespace app\components\fileAnalyzer;

use app\models\File;

interface IFileAnalyzer
{

    public function run(File $file);


    public function getText() : string;
}
