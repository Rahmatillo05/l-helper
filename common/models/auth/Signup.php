<?php

namespace common\models\auth;

use common\models\user\User;
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
            [['verification', 'username', 'password'], 'string', 'min' => 3],
            [['verification'], 'unique', 'targetClass' => User::class, 'targetAttribute' => ['email', 'phone_number']],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
        ];
    }

}