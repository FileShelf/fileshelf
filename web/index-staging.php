<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'stage');
/**
 * Whether the the application is running in production environment.
 */
defined('YII_ENV_STAGE') or define('YII_ENV_STAGE', YII_ENV === 'stage');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
