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
    public function up() : bool
    {
        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey()->comment('ID'),
            'name'          => $this->string(24)->comment('Name'),
            'email'         => $this->string()->comment('E-Mail'),
            'password_hash' => $this->string()->comment('Password'),
            'access_token'  => $this->string()->comment('Access Token'),
            'refresh_token' => $this->string()->comment('Refresh Token'),
            'avatar'        => $this->string()->comment('Avatar'),
            'password'      => $this->string()->comment('Password'),
            'auth_key'      => $this->string()->comment('Auth Key'),
            'access_token'  => $this->string()->comment('Access Token'),
            'refresh_token' => $this->string()->comment('Refresh Token'),
            'is_deleted'    => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'created_by'    => $this->integer()->comment('Created by')->defaultValue(1),
            'created_at'    => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'    => $this->integer()->comment('Updated by'),
            'updated_at'    => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'    => $this->integer()->comment('Deleted by'),
            'deleted_at'    => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);

        $this->insert('{{%user}}', [
            'id'         => 1,
            'name'       => 'system',
            'created_at' => 0,
        ]);

        $this->addForeignKey('fk_user_user_created', '{{%user}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_user_user_updated', '{{%user}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_user_user_deleted', '{{%user}}', 'deleted_by', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function down() : bool
    {
        $this->dropForeignKey('fk_user_user_deleted', '{{%user}}');
        $this->dropForeignKey('fk_user_user_updated', '{{%user}}');
        $this->dropForeignKey('fk_user_user_created', '{{%user}}');
        $this->dropTable('{{%user}}');

        return true;
    }
}
