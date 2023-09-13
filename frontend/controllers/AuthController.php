<?php

namespace frontend\controllers;

use common\models\auth\Signup;
use common\models\user\User;
use common\repository\SmsProvider;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class AuthController extends Controller
{
    public $defaultAction = "login";

    /**
     * @throws InvalidConfigException
     * @throws MethodNotAllowedHttpException
     */
    public function actionSignup(Request $request): array|User
    {
        $model = new Signup();
        if ($request->isPost) {
            try {
                $model->load($request->getBodyParams(), '');
                if ($model->validate()) {
                    return $model->signup();
                } else {
                    return $model->errors;
                }
            } catch (ErrorException $exception) {
                return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionConfirmAccount(Request $request, int $user_id): array
    {
        if ($request->isPost) {
            try {
              $verification_code = $request->getBodyParams()['verification_code'];
              return (new SmsProvider())->getToken();
            }  catch (InvalidConfigException $e) {
                return ['message' => $e->getMessage(), 'code' => $e->getCode()];
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionLogin(): string
    {
        return "Log IN";
    }

    /**
     * @throws NotFoundHttpException
     */
    private function findUser(int $user_id): User
    {
        $user = User::findOne($user_id);
        if ($user instanceof User){
            return $user;
        }
        throw new NotFoundHttpException();
    }
}