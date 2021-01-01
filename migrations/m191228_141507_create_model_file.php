<?php

use app\traits\DbTextTypesTrait;
use yii\db\Migration;

/**
 * Class m191228_141507_create_model_file
 */
class m191228_141507_create_model_file extends Migration
{

    use DbTextTypesTrait;

    private $userTable = '{{%user}}';
    private $fileTable = '{{%file}}';


    /**
     * {@inheritdoc}
     */
    public function up() : bool
    {
        $this->createTable($this->fileTable, [
            'id'                => $this->primaryKey()->comment('ID'),
            'name'              => $this->string()->comment('Name')->notNull(),
            'ext'               => $this->string(8)->comment('Extension')->notNull(),
            'mimetype'          => $this->string()->comment('Mime Type'),
            'sub_directory'     => $this->string()->comment('Sub Directory'),
            'sha1_checksum'     => $this->string(40)->comment('SHA1 checksum'),
            'raw_content'       => $this->longText()->comment('Raw content'),
            'content'           => $this->longText()->comment('Content'),
            'title'             => $this->string()->comment('Title'),
            'author'            => $this->string()->comment('Author'),
            'date'              => $this->integer()->comment('Date'),
            'is_content_locked' => $this->boolean()->comment('Is content locked')->defaultValue(false),
            'byte_size'         => $this->integer()->comment('Byte size'),
            'image_width'       => $this->integer()->comment('Image width'),
            'image_height'      => $this->integer()->comment('Image height'),
            'storage_id'        => $this->integer()->comment('Storage ID')->notNull(),
            'last_analyzed_at'  => $this->integer()->comment('Last analyzed at')->defaultValue(null),
            'is_deleted'        => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'is_deletable'      => $this->boolean()->comment('Is deletable')->defaultValue(true),
            'created_by'        => $this->integer()->comment('Created by'),
            'created_at'        => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'        => $this->integer()->comment('Updated by'),
            'updated_at'        => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'        => $this->integer()->comment('Deleted by'),
            'deleted_at'        => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);
        $this->addForeignKey('fk_user_file_created', $this->fileTable, 'created_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_file_updated', $this->fileTable, 'updated_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_file_deleted', $this->fileTable, 'deleted_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_file_storage', $this->fileTable, 'storage_id', '{{%storage}}', 'id', 'RESTRICT', 'CASCADE');


        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function down() : bool
    {
        $this->dropForeignKey('fk_file_storage', $this->fileTable);
        $this->dropForeignKey('fk_user_file_created', $this->fileTable);
        $this->dropForeignKey('fk_user_file_updated', $this->fileTable);
        $this->dropForeignKey('fk_user_file_deleted', $this->fileTable);
        $this->dropTable($this->fileTable);

        return true;
    }

}
