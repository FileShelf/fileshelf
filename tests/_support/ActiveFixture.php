<?php

namespace app\tests\_support;

use yii\db\Connection;
use yii\di\Instance;

class ActiveFixture extends \yii\test\ActiveFixture
{

    /**
     * {@inheritDoc}
     *
     * When loading data into the DB via console FixtureController (not in test environment), the DB connection
     * must be set explicitly to the test connection. Otherwise, data gets loaded into the dev/prod DB.
     * When in test environment default DB and test DB are the same.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeLoad() : void
    {
        if (!YII_ENV_TEST) {
            $this->db = Instance::ensure('dbTest', Connection::class);
        }
        parent::beforeLoad();
    }


    /**
     * {@inheritDoc}
     * @throws \yii\base\InvalidConfigException
     * @see \app\tests\_support\ActiveFixture::beforeLoad
     */
    public function beforeUnload() : void
    {
        if (!YII_ENV_TEST) {
            $this->db = Instance::ensure('dbTest', Connection::class);
        }
        parent::beforeUnload();
    }


}
