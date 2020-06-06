<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * Main App Asset Bundle
 *
 * @package   app\assets
 * @copyright 2015-2019 Ostendis AG
 * @author    Tom Lutzenberger <tom.lutzenberger@ostendis.com>
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css       = [
        'css/style.scss',
    ];
    public $js        = [
        'js/fileshelf' . (YII_DEBUG ? '' : '.min') . '.js',
    ];
    public $jsOptions = [
        'defer' => true,
    ];
    public $depends   = [
        'rmrevin\yii\fontawesome\NpmFreeAssetBundle',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\GoogleFontAsset',
    ];
}
