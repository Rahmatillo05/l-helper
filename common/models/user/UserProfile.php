<?php

namespace common\models\user;

use common\models\user\search\UserProfileQuery;
use common\models\user\search\UserQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $user_id
 * @property int|null $image_id
 * @property string|null $bio
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $address
 * @property string|null $birth_date
 * @property string|null $social_accounts
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    public static function primaryKey()
    {
        return ["user_id"];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'image_id'], 'default', 'value' => null],
            [['user_id', 'image_id'], 'integer'],
            [['bio', 'first_name', 'first_name', 'address'], 'string'],
            [['social_accounts'], 'safe'],
            [['birth_date'], 'date'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'User ID',
            'image_id' => 'Image ID',
            'bio' => 'Bio',
            'social_accounts' => 'Social Accounts',
        ];
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

    /**
     * {@inheritdoc}
     * @return UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserProfileQuery(get_called_class());
    }
}
