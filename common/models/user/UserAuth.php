<?php

namespace common\models\user;

use common\DTO\CreateUserDto;
use common\repository\SmsProvider;
use Yii;
use yii\db\ActiveQuery;
use yii\httpclient\Response;

/**
 * This is the model class for table "user_auth".
 *
 * @property int $id
 * @property int|null $verification_code
 * @property string|null $token
 * @property int|null $code_expiration_date
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
            [['token'], 'string', 'max' => 255],
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

    private function generateVerificationCode(): int
    {
        return rand(100000, 999999);
    }

    public function sendVerificationCode(CreateUserDto $user): bool|array
    {
        $userAuth = new $this;
        $userAuth->user_id = $user->user_id;
        $userAuth->verification_code = $this->generateVerificationCode();
        $userAuth->code_expiration_date = time() + 3600 * 3;
        if ($user->email) {
            $userAuth->save();
            return $userAuth->sendEmail($user->email);
        }
        $userAuth->save();
        return $userAuth->sendSmsCode($user->phone_number, $userAuth->verification_code);
    }

    private function sendSmsCode(string $phone_number, string $code): bool|array
    {
        $text = "Sizning tasdiqlash raqamingiz: $code";
        return (new SmsProvider())->sendSMS($phone_number, $text);
    }

    private function sendEmail(string $email): bool
    {
        return true;
    }
}
