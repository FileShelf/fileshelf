<?php

namespace app\components;

/**
 * This component handles the Frontend view
 * Extended from the default View to implement own behaviour.
 *
 * @package app\components
 */
class View extends \yii\web\View
{

    /**
     * @var string[] Options to set for the body tag, which will be injected
     * @see \yii\bootstrap4\Html::beginTag
     */
    public $bodyOptions = [];

    /**
     * @var null|string The prefix of the page title
     */
    public $titlePrefix = '';

    /**
     * @var null|string The suffix of the page title
     */
    public $titleSuffix = '';

    /**
     * @var string The raw page title without prefix and suffix
     */
    public $titleRaw = '';

    /**
     * @var string The page description in the head
     */
    public $description = '';


    /**
     * Set the page title including prefix and suffix
     *
     * @param string      $title
     * @param string|null $prefix
     * @param string|null $suffix
     */
    public function setTitle(string $title, ?string $prefix = null, ?string $suffix = null) : void
    {
        if ($prefix !== null) {
            $this->titlePrefix = $prefix;
        }
        if ($suffix !== null) {
            $this->titleSuffix = $suffix;
        }

        $this->titleRaw = $title;
        $this->title = $this->titlePrefix . $title . $this->titleSuffix;
    }

}
