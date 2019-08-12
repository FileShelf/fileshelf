<?php

namespace app\modules\v1\models\query;

use app\modules\v1\models\StorageType;

/**
 * This is the ActiveQuery class for [[StorageType]].
 *
 * @see \app\modules\v1\models\StorageType
 */
class StorageTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StorageType[]|array
     */
    public function all($db = null)
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
