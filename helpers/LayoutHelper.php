<?php


namespace app\helpers;


use Yii;

/**
 * Class LayoutHelper
 *
 * @package   app\helpers
 * @copyright 2015-2019 Ostendis AG
 * @author    Tom Lutzenberger <tom.lutzenberger@ostendis.com>
 */
class LayoutHelper
{

    /**
     * Gets a pre-rendered string of css classes based on current controller and action
     *
     * @return string - String of css classes
     */
    public static function getLayoutCssClassString() : string
    {
        return implode(' ', static::getLayoutCssClasses());
    }


    /**
     * Get an array of css classes based on current controller and action
     *
     * @return array - List of css classes
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
