<?php

namespace tests\unit\components;

use app\components\fileAnalyzer\BaseFileAnalyzer;
use Codeception\Test\Unit;
use Helper\UnitHelper;
use UnitTester;
use Yii;

class BaseFileAnalyzerTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var \app\components\fileAnalyzer\BaseFileAnalyzer
     */
    protected $bfa;


    /**
     * @dataProvider fileNameParseProvider
     * @param string $fileName
     * @param string $author
     * @param string $title
     * @param int    $date
     * @throws \ReflectionException
     */
    public function testParseFileName(string $fileName, string $author, string $title, int $date)
    {
        $method = UnitHelper::getNonPublicMethod(BaseFileAnalyzer::class, 'parseFileName');
        $result = $method->invoke($this->bfa, $fileName);

        expect($result['author'])->equals($author);
        expect($result['title'])->equals($title);
        expect($result['date'])->equals($date);
    }


    /**
     * @return array
     */
    public function fileNameParseProvider() : array
    {
        return [
            [
                'fileName' => 'Some Title',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 0,
            ], [
                'fileName' => 'Some_other_Title',
                'author'   => '',
                'title'    => 'Some other Title',
                'date'     => 0,
            ], [
                'fileName' => 'Some_Title_-_20190120',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ], [
                'fileName' => 'Some_Author_-_Some_Subject_-_20190601',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ], [
                'fileName' => 'Some Title - 20190120',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ], [
                'fileName' => 'Some Author - Some Subject - 20190601',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ], [
                'fileName' => 'Some Title - 2019-01-20',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ], [
                'fileName' => 'Some Author - Some Subject - 2019-06-01',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ],
        ];
    }


    protected function _before()
    {
        $this->bfa = Yii::$app->fileAnalyzer;
    }
}
