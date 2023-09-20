<?php

namespace frontend\models;

use common\components\Detect;
use common\models\user\User;
use common\models\user\UserAuth;
use yii\base\Exception;
use yii\base\Model;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * @property string $user_token
 * @property  int $verification_code
 */
class ConformAccount extends Model
{
    public $user_token;
    public $verification_code;

    public function rules()
    {
        return [
            [['user_token'], 'string', 'min' => 32],
            [['verification_code'], 'integer', 'min' => 6]
        ];
    }

    /**
     * @throws Exception
     */
    public function verifyUser(): bool|array|UserAuth
    {
        $_user = $this->getUser();
        if (is_array($_user)) {
            return $_user;
        } else {
            $user = User::findOne($_user->user_id);
            $user->status = Detect::STATUS_ACTIVE;
            $_user->token = \Yii::$app->security->generateRandomString(128);
            $_user->token_expiration_date = time() + 3600 * 24 * 30;
            if ($user->save() && $_user->save()) {
                return [
                    'token' => $_user->token,
                    'user' => $user
                ];
            }
            return [
                'status' => 500,
                'message' => "Xatolik mavjud qaytadan urinib ko'ring"
            ];
        }
    }

    private function getUser(): UserAuth|array
    {
        /**
         * @var UserAuth $user_auth
         */
        $user_auth = UserAuth::find()->where([
            'relation_token' => $this->user_token
        ])->andWhere([
            'verification_code' => $this->verification_code
        ])->one();
        $data = [];
        if (!$user_auth) {
            $data['status_code'] = 422;
            $data['error_message'] = "Siz yuborgan tasdiqlash kodi xato!";
        } elseif ($user_auth->code_expiration_date <= time()) {
            $data['status_code'] = 410;
            $data['error_message'] = "Siz yuborgan tasdiqlash kodi eskirgan!";
        } else {
            return $user_auth;
        }
        return $data;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function resendCode(string $user_token)
    {
        $userAuth = UserAuth::findOne(['relation_token' => $user_token]);
        if ($userAuth) {
            $userAuth->verification_code = $userAuth->generateVerificationCode();
            $userAuth->code_expiration_date = time() + 60 * 3;
            $userAuth->save();
            return $userAuth->user->email
                ? $userAuth->sendEmail($userAuth->user->email, $userAuth->verification_code)
                : $userAuth->sendSmsCode($userAuth->user->phone_number, $userAuth->verification_code);
        }
        throw new NotFoundHttpException();
    }
}