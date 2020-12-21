<?php

use yii\db\Migration;

/**
 * Class m190722_221209_initialization
 */
class m190722_221209_initialization extends Migration
{

    protected $yiiMigrations = [
        //'m141106_185632_log_init'                                  => 'vendor/yiisoft/yii2/log/migrations/',
        'm150207_210500_i18n_init'                                 => 'vendor/yiisoft/yii2/i18n/migrations/',
        //'m150909_153426_cache_init'                                => 'vendor/yiisoft/yii2/caching/migrations/',
        'm140506_102106_rbac_init'                                 => 'vendor/yiisoft/yii2/rbac/migrations/',
        'm170907_052038_rbac_add_index_on_auth_assignment_user_id' => 'vendor/yiisoft/yii2/rbac/migrations/',
        'm180523_151638_rbac_updates_indexes_without_prefix'       => 'vendor/yiisoft/yii2/rbac/migrations/',
    ];


    /**
     * {@inheritdoc}
     */
    public function up() : bool
    {
        foreach ($this->yiiMigrations as $class => $path) {
            require_once $path . $class . '.php';
            (new $class())->up();
        }

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function down() : bool
    {
        foreach (array_reverse($this->yiiMigrations) as $class => $path) {
            require_once $path . $class . '.php';
            (new $class())->down();
        }

        return true;
    }
}
