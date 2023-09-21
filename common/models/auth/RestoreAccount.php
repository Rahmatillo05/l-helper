<?php

namespace common\models\auth;

use common\components\Detect;
use common\components\Helper;
use common\models\user\User;
use common\models\user\UserAuth;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class RestoreAccount extends Model
{
    public $verification;

    public function rules()
    {
        return [
            ['verification', 'trim'],
            ['verification', 'safe'],
            ['verification', 'required'],
        ];
    }


    /**
     * @throws NotFoundHttpException|Exception
     */
    public function restore(): array
    {
        $user = $this->findUser();
        if ($user) {
            $user_auth = UserAuth::findOne(['user_id' => $user->id]);
            $code = $user_auth->generateVerificationCode();
            $user_auth->verification_code = $code;
            $user_auth->code_expiration_date = time() + 60 * 3;
            $user_auth->token = null;
            $user_auth->token_expiration_date = null;
            $user_auth->relation_token = Yii::$app->security->generateRandomString();
            if ($user_auth->save()) {
                if (!is_null(Helper::isEmail($this->verification))) {
                    return [
                        'status' => $user_auth->sendEmail($this->verification, $code),
                        'user_token' => $user_auth->relation_token
                    ];
                } else {
                    return [
                        'status' => $user_auth->sendSmsCode($this->verification, $code),
                        'user_token' => $user_auth->relation_token
                    ];
                }
            }
            return $user_auth->errors;
        }
        throw new NotFoundHttpException("Bunday foydalanuvchi mavjud emas!");
    }

    private function findUser(): bool|array|User
    {
        $user = User::find()->where(['username' => $this->verification])
            ->orWhere(['phone_number' => $this->verification])
            ->orWhere(['email' => $this->verification])
            ->andWhere(['status' => [Detect::STATUS_INACTIVE, Detect::STATUS_ACTIVE]])->one();
        if (!$user) {
            return false;
        }
        return $user;
    }
}