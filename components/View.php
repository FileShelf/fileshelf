<?php

namespace app\components;

/**
 * Class View
 *
 * @package   app\components
 * @copyright 2015-2019 Ostendis AG
 * @author    Tom Lutzenberger <tom.lutzenberger@ostendis.com>
 */
class View extends \yii\web\View
{

    public $bodyOptions = [];

    /**
     * @var string
     */
    public $titlePrefix = '';

    /**
     * @var string
     */
    public $titleSuffix = '';

    /**
     * @var string
     */
    public $titleRaw = '';

    /**
     * @var string
     */
    public $description = '';


    /**
     * Set the page title including prefix and suffix
     *
     * @param string $title
     */
    public function setTitle(string $title) : void
    {
        $this->titleRaw = $title;
        $this->title = $this->titlePrefix . $title . $this->titleSuffix;
    }

}
