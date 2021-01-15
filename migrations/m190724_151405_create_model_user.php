<?php

use yii\db\Migration;

/**
 * Class m190724_151405_create_model_user
 */
class m190724_151405_create_model_user extends Migration
{

    private $userTable = '{{%user}}';


    /**
     * {@inheritdoc}
     */
    public function up() : bool
    {
        $this->createTable($this->userTable, [
            'id'            => $this->primaryKey()->comment('ID'),
            'name'          => $this->string(24)->comment('Name'),
            'email'         => $this->string()->comment('E-Mail'),
            'password_hash' => $this->string()->comment('Password'),
            'access_token'  => $this->string()->comment('Access Token'),
            'refresh_token' => $this->string()->comment('Refresh Token'),
            'avatar'        => $this->string()->comment('Avatar'),
            'auth_key'      => $this->string()->comment('Auth Key'),
            'is_deleted'    => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'is_deletable'  => $this->boolean()->comment('Is deletable')->defaultValue(true),
            'created_by'    => $this->integer()->comment('Created by')->defaultValue(1),
            'created_at'    => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'    => $this->integer()->comment('Updated by'),
            'updated_at'    => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'    => $this->integer()->comment('Deleted by'),
            'deleted_at'    => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);

        $this->insert($this->userTable, [
            'id'           => 1,
            'name'         => 'system',
            'is_deletable' => false,
            'created_at'   => 0,
            'created_by'   => 1,
        ]);
        $this->insert($this->userTable, [
            'id'            => 2,
            'name'          => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin', 4),
            'is_deletable'  => false,
            'created_at'    => 0,
            'created_by'    => 1,
        ]);

        $this->addForeignKey('fk_user_user_created', $this->userTable, 'created_by', $this->userTable, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_user_user_updated', $this->userTable, 'updated_by', $this->userTable, 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_user_user_deleted', $this->userTable, 'deleted_by', $this->userTable, 'id', 'SET NULL', 'CASCADE');

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function down() : bool
    {
        $this->dropForeignKey('fk_user_user_deleted', $this->userTable);
        $this->dropForeignKey('fk_user_user_updated', $this->userTable);
        $this->dropForeignKey('fk_user_user_created', $this->userTable);
        $this->dropTable($this->userTable);

        return true;
    }
}
