<?php

use yii\db\Migration;
use yii\helpers\FileHelper;

/**
 * Class m190724_182258_create_model_storage
 */
class m190724_182258_create_model_storage extends Migration
{

    private $userTable        = '{{%user}}';
    private $storageTable     = '{{%storage}}';
    private $storageTypeTable = '{{%storage_type}}';


    /**
     * {@inheritdoc}
     */
    public function safeUp() : bool
    {
        $storageTypeDefaultId = 1;
        $storageDefaultId = 1;
        $userDefaultId = 1;

        $this->createTable($this->storageTypeTable, [
            'id'           => $this->primaryKey()->comment('ID'),
            'name'         => $this->string()->comment('Name')->notNull(),
            'icon'         => $this->string()->comment('Icon'),
            'formats'      => $this->string()->comment('Formats'),
            'is_deleted'   => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'is_deletable' => $this->boolean()->comment('Is deletable')->defaultValue(true),
            'created_by'   => $this->integer()->comment('Created by'),
            'created_at'   => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'   => $this->integer()->comment('Updated by'),
            'updated_at'   => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'   => $this->integer()->comment('Deleted by'),
            'deleted_at'   => $this->integer()->comment('Deleted at')->defaultValue(null),
            'deleted_by'  => $this->integer()->comment('Deleted by'),
            'deleted_at'  => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);
        $this->insert($this->storageTypeTable, [
            'id'           => $storageTypeDefaultId,
            'name'         => 'Documents',
            'formats'      => '*.pdf;*.doc;*.docx;*.txt;*.rtf',
            'created_by'   => $userDefaultId,
            'created_at'   => 0,
            'is_deletable' => false,
        ]);
        $this->addForeignKey('fk_user_storage_type_created', $this->storageTypeTable, 'created_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_type_updated', $this->storageTypeTable, 'updated_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_type_deleted', $this->storageTypeTable, 'deleted_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');

        $this->createTable($this->storageTable, [
            'id'              => $this->primaryKey()->comment('ID'),
            'name'            => $this->string()->comment('Name')->notNull(),
            'icon'            => $this->string()->comment('Icon'),
            'path'            => $this->string()->comment('Path')->notNull(),
            'storage_type_id' => $this->integer()->comment('StorageType ID')->notNull(),
            'is_deleted'      => $this->boolean()->comment('Is deleted')->defaultValue(false),
            'is_deletable'    => $this->boolean()->comment('Is deletable')->defaultValue(true),
            'created_by'      => $this->integer()->comment('Created by'),
            'created_at'      => $this->integer()->comment('Created at')->defaultValue(null),
            'updated_by'      => $this->integer()->comment('Updated by'),
            'updated_at'      => $this->integer()->comment('Updated at')->defaultValue(null),
            'deleted_by'      => $this->integer()->comment('Deleted by'),
            'deleted_at'      => $this->integer()->comment('Deleted at')->defaultValue(null),
            'deleted_by'      => $this->integer()->comment('Deleted by'),
            'deleted_at'      => $this->integer()->comment('Deleted at')->defaultValue(null),
        ]);
        $this->insert($this->storageTable, [
            'id'              => $storageDefaultId,
            'name'            => 'Default',
            'path'            => FileHelper::normalizePath(Yii::getAlias('@runtime/data/defaultStorage')),
            'storage_type_id' => $storageTypeDefaultId,
            'is_deletable'    => false,
            'created_by'      => $userDefaultId,
            'created_at'      => 0,
        ]);
        $this->addForeignKey('fk_user_storage_created', $this->storageTable, 'created_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_updated', $this->storageTable, 'updated_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_deleted', $this->storageTable, 'deleted_by', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_storage_deleted', '{{%storage}}', 'deleted_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_storage_type_storage', $this->storageTable, 'storage_type_id', $this->storageTypeTable, 'id', 'RESTRICT', 'CASCADE');

        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown() : bool
    {
        $this->dropForeignKey('fk_user_storage_created', $this->storageTable);
        $this->dropForeignKey('fk_user_storage_updated', $this->storageTable);
        $this->dropForeignKey('fk_user_storage_deleted', $this->storageTable);
        $this->dropForeignKey('fk_storage_type_storage', $this->storageTable);
        $this->dropTable($this->storageTable);

        $this->dropForeignKey('fk_user_storage_type_created', $this->storageTypeTable);
        $this->dropForeignKey('fk_user_storage_type_updated', $this->storageTypeTable);
        $this->dropForeignKey('fk_user_storage_type_deleted', $this->storageTypeTable);
        $this->dropTable($this->storageTypeTable);

        return true;
    }

}
