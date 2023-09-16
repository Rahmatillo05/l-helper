<?php

namespace frontend\controllers;

use common\models\auth\Signup;
use common\models\user\User;
use common\models\user\UserAuth;
use common\repository\SmsProvider;
use frontend\models\ConformAccount;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
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
            } catch (Exception $e) {
                return ['message' => $e->getMessage(), 'code' => $e->getCode()];
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * @throws MethodNotAllowedHttpException
     * @throws Exception
     */
    public function actionConfirmAccount(): bool|array|UserAuth
    {
        $model = new ConformAccount();
        if (Yii::$app->request->isPost) {
            if ($model->load($this->request->post(), '')) {
                return $model->verifyUser();
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    /**
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedHttpException
     */
    public function actionResendCode(Request $request)
    {
        if ($request->isPost) {
            $data = $request->getBodyParams();
            if (!empty($data['user_token'])) {
                return (new ConformAccount())->resendCode($data['user_token']);
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