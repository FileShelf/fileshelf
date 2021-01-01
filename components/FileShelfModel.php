<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * Class FileShelfModel
 *
 * @package   app\components
 *
 * @property int      $id            ID
 * @property int|null $created_by    Created by
 * @property int|null $created_at    Created at
 * @property int|null $updated_by    Updated by
 * @property int|null $updated_at    Updated at
 * @property int|null $deleted_by    Deleted by
 * @property int|null $deleted_at    Deleted at
 * @property boolean  $is_deleted    Is deleted
 * @property boolean  $is_deletable  Is deletable
 *
 * @property User     $createdBy
 * @property User     $deletedBy
 * @property User     $updatedBy
 */
class FileShelfModel extends ActiveRecord
{

    public const SCENARIO_CREATE = 'create';
    public const SCENARIO_UPDATE = 'update';


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp'  => TimestampBehavior::class,
            'blameable'  => BlameableBehavior::class,
            'softDelete' => [
                'class'                     => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                ],
            ],
        ];
    }


    public function beforeDelete()
    {
        if (!$this->is_deletable) {
            return false;
        }

        return parent::beforeDelete();
    }


    public function afterSoftDelete()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $this->deleted_by = $user->id;
        $this->deleted_at = time();

        $this->save(false);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted', 'is_deletable', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('model', 'ID'),
            'is_deleted'   => Yii::t('model', 'Is deleted'),
            'is_deletable' => Yii::t('model', 'Is deletable'),
            'created_by'   => Yii::t('model', 'Created by'),
            'created_at'   => Yii::t('model', 'Created at'),
            'updated_by'   => Yii::t('model', 'Updated by'),
            'updated_at'   => Yii::t('model', 'Updated at'),
            'deleted_by'   => Yii::t('model', 'Deleted by'),
            'deleted_at'   => Yii::t('model', 'Deleted at'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
