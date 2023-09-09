<?php

namespace frontend\controllers;

use common\models\auth\Signup;
use common\models\user\User;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Request;

class AuthController extends Controller
{
    public $defaultAction = "login";

    /**
     * @throws InvalidConfigException
     * @throws MethodNotAllowedHttpException
     */
    public function actionSignup(Request $request)
    {
        $model = new Signup();
        if ($request->isPost) {
            try {
                $model->load($request->getBodyParams(), '');
                if ($model->validate()) {
                    return  $model->signup();
                } else {
                    return $model->errors;
                }
            } catch (ErrorException $exception) {
                return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
            }
        }
        throw new MethodNotAllowedHttpException();
    }

    public function actionLogin(): string
    {
        return "Log IN";
    }
}