<?php

namespace frontend\controllers;

use yii\rest\Controller;

class AuthController extends Controller
{
    public $defaultAction = "signup";

    public function actionSignup(): string
    {
        return "Sign UP";
    }
}