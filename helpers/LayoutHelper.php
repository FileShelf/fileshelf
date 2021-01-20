<?php

namespace app\helpers;

use Yii;

/**
 * Class LayoutHelper
 *
 * @package app\helpers
 */
class LayoutHelper
{

    /**
     * Gets a pre-rendered string of CSS classes based on the current controller and action
     *
     * @return string String of CSS classes to use in HTML
     */
    public static function getLayoutCssClassString() : string
    {
        return implode(' ', static::getLayoutCssClasses());
    }


    /**
     * Get an array of css classes based on current controller and action
     *
     * @return array List of CSS classes
     */
    public static function getLayoutCssClasses() : array
    {
        return [
            'app'    => Yii::$app->id,
            'ctrl'   => 'ctrl-' . Yii::$app->controller->id,
            'action' => Yii::$app->controller->id . '-' . Yii::$app->controller->action->id,
        ];
    }
}
