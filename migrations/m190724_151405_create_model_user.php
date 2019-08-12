<?php

use yii\db\Migration;

/**
 * Class m190724_151405_create_model_user
 */
class m190724_151405_create_model_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'         => $this->primaryKey()->comment('ID'),
            'name'       => $this->string()->comment('Name'),
            'avatar'     => $this->string()->comment('Icon'),
            'formats'    => $this->string()->comment('Formats'),
            'created_by'  => $this->integer()->comment('Created by'),
            'created_at'  => $this->integer()->comment('Created at')->defaultValue(null),
            'modified_by' => $this->integer()->comment('Modified by'),
            'modified_at' => $this->integer()->comment('Modified at')->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
