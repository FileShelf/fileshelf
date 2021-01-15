<?php

namespace app\components\console\controller;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\di\Instance;
use yii\rbac\DbManager;

class MigrateController extends \yii\console\controllers\MigrateController
{

    public $testEnv = false;


    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($this->testEnv) {
            $this->db = Instance::ensure('dbTest', Connection::class);
            $this->fixTestEnvRbacMigration();
        }

        return parent::beforeAction($action);
    }


    protected function fixTestEnvRbacMigration()
    {
        $authManager = Yii::$app->getAuthManager();

        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        $authManager->db = Instance::ensure('dbTest', Connection::class);

    }


    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), [
            'testEnv',
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            't' => 'testEnv',
        ]);
    }
}
