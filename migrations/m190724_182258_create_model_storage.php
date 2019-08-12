<?php

use yii\db\Migration;

/**
 * Class m190724_182258_create_model_storage
 */
class m190724_182258_create_model_storage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%storage_type}}', [
            'id'          => $this->primaryKey()->comment('ID'),
            'name'        => $this->string()->comment('Name')->notNull(),
            'icon'        => $this->string()->comment('Icon'),
            'formats'     => $this->string()->comment('Formats'),
            'created_by'  => $this->integer()->comment('Created by'),
            'created_at'  => $this->integer()->comment('Created at')->defaultValue(null),
            'modified_by' => $this->integer()->comment('Modified by'),
            'modified_at' => $this->integer()->comment('Modified at')->defaultValue(null),
        ]);
        $this->addForeignKey('fk_user_storage_type_created', '{{%storage_type}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_type_modified', '{{%storage_type}}', 'modified_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');


        $this->createTable('{{%storage}}', [
            'id'              => $this->primaryKey()->comment('ID'),
            'name'            => $this->string()->comment('Name')->notNull(),
            'icon'            => $this->string()->comment('Icon'),
            'path'            => $this->string()->comment('Path')->notNull(),
            'storage_type_id' => $this->integer()->comment('StorageType ID')->notNull(),
            'created_by'      => $this->integer()->comment('Created by'),
            'created_at'      => $this->integer()->comment('Created at')->defaultValue(null),
            'modified_by'     => $this->integer()->comment('Modified by'),
            'modified_at'     => $this->integer()->comment('Modified at')->defaultValue(null),
        ]);
        $this->addForeignKey('fk_user_storage_created', '{{%storage}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_modified', '{{%storage}}', 'modified_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_storage_type_storage', '{{%storage}}', 'storage_type_id', '{{%storage_type}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_storage_created', '{{%storage}}');
        $this->dropForeignKey('fk_user_storage_modified', '{{%storage}}');
        $this->dropForeignKey('fk_storage_type_storage', '{{%storage}}');
        $this->dropTable('{{%storage}}');

        $this->dropForeignKey('fk_user_storage_type_created', '{{%storage_type}}');
        $this->dropForeignKey('fk_user_storage_type_modified', '{{%storage_type}}');
        $this->dropTable('{{%storage_type}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190724_182258_create_model_storage cannot be reverted.\n";

        return false;
    }
    */
}
