<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class GoogleFontAsset
 * Google Font Asset Bundle
 *
 * @package   app\assets
 */
class GoogleFontAsset extends AssetBundle
{

    public $baseUrl = 'https://fonts.googleapis.com/';

    public $css        = [
        // Generated URL comes here after init()
    ];
    public $cssOptions = [
        'type' => 'text/css',
    ];

    protected $fonts = [
        'Open+Sans:300,400,500,700',
        'Roboto:100,300,400,500,700',
    ];


    public function init() : void
    {
        parent::init();
        $this->css = [
            'css?family=' . implode('|', $this->fonts),
        ];
    }
}
