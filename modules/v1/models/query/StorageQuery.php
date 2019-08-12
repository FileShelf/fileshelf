<?php

namespace app\modules\v1\models\query;

use app\modules\v1\models\Storage;

/**
 * This is the ActiveQuery class for [[Storage]].
 *
 * @see \app\modules\v1\models\Storage
 */
class StorageQuery extends \yii\db\ActiveQuery
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
