<?php

use yii\db\Migration;

/**
 * Class m191228_141507_create_model_file
 */
class m191228_141507_create_model_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id'               => $this->primaryKey()->comment('ID'),
            'name'             => $this->string()->comment('Name')->notNull(),
            'ext'              => $this->string()->comment('Extension'),
            'mimetype'         => $this->string()->comment('Mime Type'),
            'content'          => $this->string()->comment('Content'),
            'byte_size'        => $this->integer()->comment('Byte size'),
            'image_width'      => $this->integer()->comment('Image width'),
            'image_height'     => $this->integer()->comment('Image height'),
            'last_analyzed_at' => $this->integer()->comment('Last analyzed at')->defaultValue(null),
            'is_deleted'       => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'created_by'       => $this->integer()->comment('Created by'),
            'created_at'       => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'       => $this->integer()->comment('Updated by'),
            'updated_at'       => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'       => $this->integer()->comment('Deleted by'),
            'deleted_at'       => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);
        $this->addForeignKey('fk_user_storage_type_created', '{{%storage_type}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_type_updated', '{{%storage_type}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_type_deleted', '{{%storage_type}}', 'deleted_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191228_141507_create_model_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191228_141507_create_model_file cannot be reverted.\n";

        return false;
    }
    */
}
