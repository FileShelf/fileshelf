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
     *
     * @param string $fileName
     * @param string $author
     * @param string $title
     * @param int    $date
     * @throws \ReflectionException
     */
    public function testParseFileName(string $fileName, string $author, string $title, int $date) : void
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
            'Simple spaced title'                              => [
                'fileName' => 'Some Title',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 0,
            ],
            'Simple underscored title'                         => [
                'fileName' => 'Some_other_Title',
                'author'   => '',
                'title'    => 'Some other Title',
                'date'     => 0,
            ],
            'Spaced title and collapsed date'                  => [
                'fileName' => 'Some Title - 20190120',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ],
            'Underscored title and collapsed date'             => [
                'fileName' => 'Some_Title_-_20190120',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ],
            'Spaced Author, title and collapsed date'          => [
                'fileName' => 'Some Author - Some Subject - 20190601',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ],
            'Underscored Author, title and collapsed date'     => [
                'fileName' => 'Some_Author_-_Some_Subject_-_20190601',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ],
            'Spaced title and expanded date'                   => [
                'fileName' => 'Some Title - 2019-01-20',
                'author'   => '',
                'title'    => 'Some Title',
                'date'     => 1547942400,
            ],
            'Spaced Author, title and expanded date'           => [
                'fileName' => 'Some Author - Some Subject - 2019-06-01',
                'author'   => 'Some Author',
                'title'    => 'Some Subject',
                'date'     => 1559347200,
            ],
            'Simple title with dashes'                         => [
                'fileName' => 'Some-longer-Title',
                'author'   => '',
                'title'    => 'Some-longer-Title',
                'date'     => 0,
            ],
            'Simple title with dashes, spaces and underscores' => [
                'fileName' => 'Some-longer Title_with-strange_spacing',
                'author'   => '',
                'title'    => 'Some-longer Title with-strange spacing',
                'date'     => 0,
            ],
            'Simple title with multiple spacings'              => [
                'fileName' => 'Extra _ spacing_ _Title',
                'author'   => '',
                'title'    => 'Extra spacing Title',
                'date'     => 0,
            ],
            'Simple title with overlapping spacings'           => [
                'fileName' => '  Overlapping spacing Title__',
                'author'   => '',
                'title'    => 'Overlapping spacing Title',
                'date'     => 0,
            ],
        ];
    }


    protected function _before() : void
    {
        $this->bfa = Yii::$app->fileAnalyzer;
    }
}
