<?php

namespace frontend\controllers;

use common\models\auth\Signup;
use common\models\user\User;
use common\models\user\UserAuth;
use common\repository\SmsProvider;
use frontend\models\ConformAccount;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class AuthController extends Controller
{
    public $defaultAction = "login";

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class
        ];
        return $behaviors;
    }

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

    public function actionConfirmAccount()
    {
        $model = new ConformAccount();
        if (Yii::$app->request->isPost){
            if ($model->load($this->request->post(), '')){
                return $model->verifyUser();
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
        if ($user instanceof User) {
            return $user;
        }
        throw new NotFoundHttpException();
    }
}