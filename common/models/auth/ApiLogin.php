<?php

namespace common\models\auth;

use common\models\user\User;
use common\models\user\UserAuth;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Login form
 */
class ApiLogin extends Model
{
    public $username;
    public $password;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param string $attribute the attribute currently being validated
     * @param array|null $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array|null $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return array|bool
     * @throws Exception
     */
    public function login(): bool|array
    {
        if ($this->validate()) {
            if ($this->_user) {
                $auth = UserAuth::findOne(['user_id' => $this->_user->id]);
                $auth->token = Yii::$app->security->generateRandomString(128);
                $auth->token_expiration_date = time() + 3600 * 24 * 30;
                $auth->save();
                return [
                    'token' => $auth->token,
                    'user' => $this->_user
                ];
            }
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
