<?php


namespace app\traits;

use yii\db\ColumnSchemaBuilder;
use yii\db\Connection;

/**
 * Trait to enable tinytext, mediumtext and longtext columns in certain DB drivers
 *
 * @package app\traits
 */
trait DbTextTypesTrait
{


    /**
     * Creates a medium text column.
     *
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws \yii\base\NotSupportedException
     */
    public function mediumText() : ColumnSchemaBuilder
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext');
    }


    /**
     * @return Connection the database connection to be used for schema building.
     */
    abstract protected function getDb() : Connection;


    /**
     * Creates a long text column.
     *
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws \yii\base\NotSupportedException
     */
    public function longText() : ColumnSchemaBuilder
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext');
    }


    /**
     * Creates a tiny text column.
     *
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws \yii\base\NotSupportedException
     */
    public function tinyText() : ColumnSchemaBuilder
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('tinytext');
    }
}
