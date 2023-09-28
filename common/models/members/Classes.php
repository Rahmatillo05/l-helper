<?php

namespace common\models\members;

use common\models\organization\Organization;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property int|null $school_id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Member[] $members
 * @property Organization $school
 */
class Classes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['school_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Members]].
     *
     * @return ActiveQuery
     */
    public function getMembers(): ActiveQuery
    {
        return $this->hasMany(Member::class, ['class_id' => 'id']);
    }

    /**
     * Gets query for [[School]].
     *
     * @return ActiveQuery
     */
    public function getSchool(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'school_id']);
    }
}
