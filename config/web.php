<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'         => 'fileshelf',
    'name'       => 'FileShelf',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4eb998a0e357a085a9e0b8206ade1a6fab5837b0',
            'parsers'             => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'assetManager' => [
            'bundles'         => [
                'yii\bootstrap4\BootstrapAsset'              => [
                    'css' => [],
                ],
                'yii\bootstrap4\BootstrapPluginAsset'        => [
                    'js'        => [
                        'js/bootstrap.bundle.min.js',
                    ],
                    'jsOptions' => [
                        'defer' => true,
                    ],
                ],
                'yii\web\JqueryAsset'                        => [
                    'js'        => [
                        'jquery.min.js',
                    ],
                    'jsOptions' => [],
                ],
                'rmrevin\yii\fontawesome\NpmFreeAssetBundle' => [
                    'css'            => [],
                    'publishOptions' => [
                        'only'      => [
                            // Copy only the fonts, because the FA styles are included differently
                            'webfonts/*',
                        ],
                        'afterCopy' => static function ($from, $to) {
                            // Overwrite font file destination path
                            if (!is_file($from)) {
                                return;
                            }
                            $fontPos = strpos($from, 'webfonts');
                            if ($fontPos !== false && strpos($to, 'js-packages') === false) {
                                $newPath = __DIR__ . '/../web/webfonts' . substr($from, $fontPos + 8);
                                copy($from, $newPath);
                            }
                        },
                    ],
                ],
            ],
            'converter'       => [
                'class'        => 'yii\web\AssetConverter',
                'commands'     => [
                    'scss' => ['css', '@app/node_modules/.bin/node-sass --output-style=compressed {from} {to}'],
                ],
                'forceConvert' => YII_ENV_DEV,
            ],
            'appendTimestamp' => true,
        ],
        'view'         => [
            'class'       => 'app\components\View',
            'titlePrefix' => '',
            'titleSuffix' => ' | FileShelf',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,

        'i18n'       => [
            'translations' => [
                '*' => [
                    'class'         => 'yii\i18n\DbMessageSource',
                    'enableCaching' => !YII_ENV_DEV,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [
                ''         => 'site/index',
                '<action>' => 'site/<action>',
            ],
        ],

        'fileAnalyzer' => [
            'class' => 'app\components\fileAnalyzer\BaseFileAnalyzer',
        ],
        'fileScanner'  => [
            'class' => 'app\components\FileScanner',
        ],
    ],
    'modules'    => [],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
