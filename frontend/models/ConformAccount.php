<?php

namespace frontend\models;

use common\components\Detect;
use common\models\user\User;
use common\models\user\UserAuth;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

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
            $data['status_code'] = 404;
            $data['error_message'] = "Siz yuborgan tasdiqlash kodi mavjud emas!";
        } elseif ($user_auth->code_expiration_date <= time()) {
            $data['status_code'] = 410;
            $data['error_message'] = "Siz yuborgan tasdiqlash kodi eskirgan!";
        } else {
            return $user_auth;
        }
        return $data;
    }
}