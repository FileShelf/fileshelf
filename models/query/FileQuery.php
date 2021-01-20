<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\File]].
 *
 * @see \app\models\File
 */
class FileQuery extends ActiveQuery
{

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\File[]|array
     */
    public function all($db = null) : array
    {
        return parent::all($db);
    }


    /**
     * {@inheritdoc}
     * @return \app\models\File|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
