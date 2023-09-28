<?php

namespace common\models\members;

use common\models\organization\Organization;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int|null $user_id
 * @property int|null $class_id
 * @property int|null $author_id
 * @property string|null $full_name
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $member_type
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property Classes $class
 * @property Organization $organization
 * @property User $user
 */
class Member extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'user_id', 'class_id', 'author_id', 'status', 'member_type', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'address', 'phone'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::class, 'targetAttribute' => ['class_id' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'user_id' => 'User ID',
            'class_id' => 'Class ID',
            'author_id' => 'Author ID',
            'full_name' => 'Full Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'status' => 'Status',
            'member_type' => 'Member Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Class]].
     *
     * @return ActiveQuery
     */
    public function getClass(): ActiveQuery
    {
        return $this->hasOne(Classes::class, ['id' => 'class_id']);
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return ActiveQuery
     */
    public function getOrganization(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
