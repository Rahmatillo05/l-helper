<?php

namespace common\models\auth;

use common\components\Helper;
use common\DTO\CreateUserDto;
use common\models\user\User;
use common\models\user\UserAuth;
use yii\base\Exception;
use yii\base\Model;

class Signup extends Model
{
    public $verification; // Email yoki Telefon raqam
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['verification', 'username', 'password'], 'required'],
            [['verification', 'username'], 'string', 'min' => 3],
            [['password'], 'string', 'min' => 8],
            ['verification', 'validateUnique'],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
        ];
    }

    /**
     * @throws Exception
     */
    public function signup(): array|User
    {
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->email = Helper::isEmail($this->verification);
        $user->phone_number = Helper::isPhoneNumber($this->verification);
        if ($user->save()){
            $userDto = new CreateUserDto();
            $userDto->phone_number = $user->phone_number;
            $userDto->email = $user->email;
            $userDto->auth_key = $user->auth_key;
            $userDto->password_hash = $user->password_hash;
            $userDto->user_id = $user->id;
            $response = (new UserAuth())->sendVerificationCode($userDto);
            return [
                'status_code'=> $response['status_code'],
                'user_token' => $response['relation_token']
            ];
        }
        return $user->errors;
    }



    public function validateUnique($attribute, $params): void
    {
        $user = User::find()->where(['email' => $this->verification])
            ->orWhere(['phone_number' => $this->verification])
            ->all();
        if (!empty($user)) {
            $this->addError($attribute, "Siz yuborgan {$this->verification} avvalroq band qilingan!");
        }
    }
}