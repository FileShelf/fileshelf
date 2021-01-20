<?php

namespace app\components\console\controller;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\di\Instance;
use yii\rbac\DbManager;

/**
 * This controller executes migrations
 * Extended from the default controller to implement own behaviour.
 *
 * @package app\components\console\controller
 */
class MigrateController extends \yii\console\controllers\MigrateController
{

    /**
     * @var bool whether the action should be executed on the test environment or not
     */
    public $testEnv = false;


    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeAction($action) : bool
    {
        if ($this->testEnv) {
            $this->db = Instance::ensure('dbTest', Connection::class);
        }

        try {
            $this->fixTestEnvRbacMigration();
        } catch (InvalidConfigException $e) {
            $this->stderr($e);
            return false;
        }

        return parent::beforeAction($action);
    }


    /**
     * Replaces the AuthManager DB connection with the Test DB connection, to enable RBAC migrations against the Test DB
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function fixTestEnvRbacMigration() : void
    {
        if ($this->testEnv) {
            $authManager = Yii::$app->getAuthManager();

            if (!$authManager instanceof DbManager) {
                $message = 'You should configure "authManager" component to use database before executing this migration.';
                throw new InvalidConfigException($message);
            }

            $authManager->db = Instance::ensure('dbTest', Connection::class);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function options($actionID) : array
    {
        return array_merge(parent::options($actionID), [
            'testEnv',
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function optionAliases() : array
    {
        return array_merge(parent::optionAliases(), [
            't' => 'testEnv',
        ]);
    }
}
