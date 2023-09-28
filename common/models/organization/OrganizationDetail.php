<?php

namespace common\models\organization;

use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "organization_detail".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int|null $user_id
 * @property string|null $address
 * @property string|null $description
 * @property string|null $coordinates
 * @property string|null $social_link
 *
 * @property Organization $organization
 * @property User $user
 */
class OrganizationDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'organization_detail';
    }
    public static function primaryKey(): array
    {
        return ["organization_id"];
    }
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['organization_id', 'user_id'], 'default', 'value' => null],
            [['organization_id', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['social_link'], 'safe'],
            [['address', 'coordinates'], 'string', 'max' => 255],
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
            'organization_id' => 'Organization ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'description' => 'Description',
            'coordinates' => 'Coordinates',
            'social_link' => 'Social Link',
        ];
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
