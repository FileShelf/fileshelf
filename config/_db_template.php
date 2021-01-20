<?php

if (YII_ENV_PROD) {
    return [
        'class'    => 'yii\db\Connection',
        'dsn'      => 'mysql:host=127.0.0.1;dbname=my_database',
        'username' => 'root',
        'password' => 'password',
        'charset'  => 'utf8',

        'enableQueryCache'   => !YII_DEBUG,
        'queryCacheDuration' => 3600,
    ];
}

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'mysql:host=127.0.0.1;dbname=my_database',
    'username' => 'root',
    'password' => 'password',
    'charset'  => 'utf8',
];
