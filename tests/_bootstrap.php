<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);
/**
 * Whether the the application is running in staging environment.
 */
defined('YII_ENV_STAGE') or define('YII_ENV_STAGE', YII_ENV === 'stage');

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../vendor/autoload.php';
