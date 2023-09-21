<?php

namespace common\models\user;

use common\DTO\CreateUserDto;
use common\repository\SmsProvider;
use mrmuminov\eskizuz\request\sms\SmsSendRequest;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\httpclient\Response;

/**
 * This is the model class for table "user_auth".
 *
 * @property int $id
 * @property int|null $verification_code
 * @property string|null $relation_token
 * @property string|null $token
 * * @property int|null $code_expiration_date
 * @property int|null $token_expiration_date
 * @property int $user_id
 *
 * @property User $user
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['verification_code', 'code_expiration_date', 'token_expiration_date', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['token', 'relation_token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'verification_code' => 'Verification Code',
            'token' => 'Token',
            'relation_token' => 'User Token',
            'code_expiration_date' => 'Code Expiration Date',
            'token_expiration_date' => 'Token Expiration Date',
            'user_id' => 'User ID',
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

    public function generateVerificationCode(): int
    {
        return rand(100000, 999999);
    }

    /**
     * @throws Exception
     */
    public function sendVerificationCode(CreateUserDto $user): array
    {
        $userAuth = new $this;
        $userAuth->user_id = $user->user_id;
        $userAuth->verification_code = $this->generateVerificationCode();
        $userAuth->code_expiration_date = time() + 60 * 3;
        $userAuth->relation_token = Yii::$app->security->generateRandomString();
        $userAuth->save();
        if ($user->email) {
            return [
                'relation_token' => $userAuth->relation_token,
                'status_code' => $userAuth->sendEmail($user->email)
            ];
        }
        return [
            'relation_token' => $userAuth->relation_token,
            'status_code' => $userAuth->sendSmsCode($user->phone_number, $userAuth->verification_code)
        ];
    }

    public function sendSmsCode(string $phone_number, string $code)
    {
        $text = "Sizning tasdiqlash raqamingiz: $code";
        return (new SmsProvider())->sendSMS($phone_number, $text);
    }

    public function sendEmail(string $email): bool
    {
        return true;
    }
}
