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
    public function up() : bool
    {
        $this->createTable('{{%file}}', [
            'id'                => $this->primaryKey()->comment('ID'),
            'name'              => $this->string()->comment('Name')->notNull(),
            'ext'               => $this->string(8)->comment('Extension')->notNull(),
            'mimetype'          => $this->string()->comment('Mime Type'),
            'sub_directory'     => $this->string()->comment('Sub Directory'),
            'sha1_checksum'     => $this->string(40)->comment('SHA1 checksum'),
            'raw_content'       => $this->text()->comment('Raw content'),
            'content'           => $this->text()->comment('Content'),
            'is_content_locked' => $this->boolean()->comment('Is content locked')->defaultValue(false),
            'byte_size'         => $this->integer()->comment('Byte size'),
            'image_width'       => $this->integer()->comment('Image width'),
            'image_height'      => $this->integer()->comment('Image height'),
            'storage_id'        => $this->integer()->comment('Storage ID')->notNull(),
            'last_analyzed_at'  => $this->integer()->comment('Last analyzed at')->defaultValue(null),
            'is_deleted'        => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'created_by'        => $this->integer()->comment('Created by'),
            'created_at'        => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'        => $this->integer()->comment('Updated by'),
            'updated_at'        => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'        => $this->integer()->comment('Deleted by'),
            'deleted_at'        => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);
        $this->addForeignKey('fk_user_file_created', '{{%file}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_file_updated', '{{%file}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_file_deleted', '{{%file}}', 'deleted_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_file_storage', '{{%file}}', 'storage_id', '{{%storage}}', 'id', 'RESTRICT', 'CASCADE');


        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function down() : bool
    {
        $this->dropForeignKey('fk_file_storage', '{{%file}}');
        $this->dropForeignKey('fk_user_file_created', '{{%file}}');
        $this->dropForeignKey('fk_user_file_updated', '{{%file}}');
        $this->dropForeignKey('fk_user_file_deleted', '{{%file}}');
        $this->dropTable('{{%file}}');

        return true;
    }

}
