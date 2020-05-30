<?php

namespace app\models\query;

use app\models\Storage;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Storage]].
 *
 * @see \app\models\Storage
 */
class StorageQuery extends ActiveQuery
{

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Storage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }


    /**
     * {@inheritdoc}
     * @return Storage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
