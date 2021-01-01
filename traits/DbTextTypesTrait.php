<?php


namespace app\traits;

use yii\db\ColumnSchemaBuilder;

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
     * @return \yii\db\Connection the database connection to be used for schema building.
     */
    protected abstract function getDb();


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
