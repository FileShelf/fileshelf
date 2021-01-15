<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$dbTest = require __DIR__ . '/test_db.php';

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components'          => [
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'db'          => $db,
        'dbTest'      => $dbTest,
        'i18n'        => [
            'translations' => [
                '*' => [
                    'class'         => 'yii\i18n\DbMessageSource',
                    'enableCaching' => !YII_ENV_DEV,
                ],
            ],
        ],

        'fileAnalyzer' => [
            'class' => 'app\components\fileAnalyzer\BaseFileAnalyzer',
        ],
        'fileScanner'  => [
            'class' => 'app\components\FileScanner',
        ],
    ],
    'params'              => $params,
    'controllerMap'       => [
        'fixture'        => [
            // Fixture generation command line.
            'class'     => 'yii\faker\FixtureController',
            'namespace' => 'app\tests\unit\fixtures',
        ],
        'migrate'        => [
            'class'         => 'app\components\console\controller\MigrateController',
            'migrationPath' => [
                '@app/migrations',
            ],
        ],
        'migrate-system' => [
            'class'               => 'app\components\console\controller\MigrateController',
            'migrationPath'       => [
                //'@yii/log/migrations',
                '@yii/i18n/migrations',
                //'@yii/caching/migrations',
                '@yii/rbac/migrations',
            ],
            'migrationTable'      => '{{%migration_system}}',
            'migrationNamespaces' => null,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
