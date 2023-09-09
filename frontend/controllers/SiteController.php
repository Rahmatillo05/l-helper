<?php

namespace frontend\controllers;

use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return "Welcome to Library Helper APP";
    }
}