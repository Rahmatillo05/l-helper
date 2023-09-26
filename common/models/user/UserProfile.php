<?php

namespace common\models\user;

use common\models\user\search\UserProfileQuery;
use common\models\user\search\UserQuery;
use frontend\modules\file\models\File;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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
            [['user_id', 'image_id', 'birth_date'], 'integer'],
            [['bio', 'first_name', 'first_name', 'address'], 'string'],
            [['social_accounts'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'image'
        ]);
    }

    public function getImage(): ?File
    {
        return File::findOne($this->image_id);
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
