<?php

namespace app\models\query;

use app\models\StorageType;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[StorageType]].
 *
 * @see \app\models\StorageType
 */
class StorageTypeQuery extends ActiveQuery
{

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StorageType[]|array
     */
    public function all($db = null) : array
    {
        return parent::all($db);
    }


    /**
     * {@inheritdoc}
     * @return StorageType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
