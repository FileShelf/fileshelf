<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db'           => $db,
        'mailer'       => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager'   => [
            'showScriptName' => true,
        ],
        'user'         => [
            'identityClass' => 'app\models\User',
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request'      => [
            'cookieValidationKey'  => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'view'         => [
            'class'       => 'app\components\View',
            'titlePrefix' => '',
            'titleSuffix' => ' | FileShelf',
        ],

        'fileAnalyzer' => [
            'class' => 'app\components\fileAnalyzer\BaseFileAnalyzer',
        ],
        'fileScanner'  => [
            'class' => 'app\components\FileScanner',
        ],
    ],
    'params' => $params,
];
