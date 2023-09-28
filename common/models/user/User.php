<?php

namespace common\models\user;

use common\components\Detect;
use common\models\organization\Organization;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property integer $phone_number
 * @property integer $created_at
 * @property integer $status
 * @property integer $user_type
 * @property integer|null $organization_id
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['status', 'default', 'value' => Detect::STATUS_INACTIVE],
            ['status', 'in', 'range' => [Detect::STATUS_ACTIVE, Detect::STATUS_INACTIVE]],
            ['user_type', 'in', 'range' => [Detect::COMMON_USER, Detect::ORGANIZATION, Detect::WORKER]],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    public function fields(): array
    {
        return ArrayHelper::merge(parent::fields(), [
            'detail'
        ]);
    }

    public function getOrganization(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getDetail(): ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|IdentityInterface|null
    {
        return static::findOne(['id' => $id, 'status' => Detect::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws ForbiddenHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null): User|IdentityInterface|null
    {
        $userAuth = UserAuth::find()->where(['token' => $token])
            ->andWhere(['>', 'token_expiration_date', time()])->one();
        if ($userAuth){
            return self::findOne(['id' => $userAuth->user_id, 'status' => Detect::STATUS_ACTIVE]);
        }
        throw new ForbiddenHttpException("Siz yuborgan token eskirgan yoki bunday foydalanuvchi mavjud emas!");
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|null
     */
    public static function findByUsername(string $username): User|null
    {
        return static::findOne(['username' => $username, 'status' => Detect::STATUS_ACTIVE]);
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

}
