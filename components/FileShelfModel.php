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
 * The main data model of which all others should extend
 * Extended from the default Model ActiveRecord to implement own behaviour.
 *
 * @package   app\components
 *
 * @property int      $id           ID
 * @property int|null $created_by   Created by
 * @property int|null $created_at   Created at
 * @property int|null $updated_by   Updated by
 * @property int|null $updated_at   Updated at
 * @property int|null $deleted_by   Deleted by
 * @property int|null $deleted_at   Deleted at
 * @property boolean  $is_deleted   Is deleted
 * @property boolean  $is_deletable Is deletable
 *
 * @property User     $createdBy
 * @property User     $deletedBy
 * @property User     $updatedBy
 */
class FileShelfModel extends ActiveRecord
{

    /**
     * @var string The name of the create scenario
     * TODO: Implement this scenario
     */
    public const SCENARIO_CREATE = 'create';

    /**
     * @var string The name of the update scenario
     * TODO: Implement this scenario
     */
    public const SCENARIO_UPDATE = 'update';


    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        return [
            'timestamp'  => TimestampBehavior::class,
            'blameable'  => BlameableBehavior::class,
            'softDelete' => [
                'class'                     => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                ],
                // TODO: Implement `allowDeleteCallback`
            ],
        ];
    }


    /**
     * {@inheritdoc}
     * TODO: Have a closer look at SoftDeleteBehavior
     *
     * @see SoftDeleteBehavior::softDelete
     */
    public function beforeDelete() : bool
    {
        if (!$this->is_deletable) {
            return false;
        }

        return parent::beforeDelete();
    }


    /**
     * Action to perform after softDelete
     *
     * TODO: Is this right?
     *
     * @see SoftDeleteBehavior::afterSoftDelete
     */
    public function afterSoftDelete() : void
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
    public function rules() : array
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
    public function attributeLabels() : array
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
     * Returns the related User, which created the current model
     *
     * Lazy loaded.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }


    /**
     * Returns the related User, which (soft-)deleted the current model
     *
     * Lazy loaded.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }


    /**
     * Returns the related User, which last updated the current model
     *
     * Lazy loaded.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
