<?php

namespace frontend\modules\file\controllers;

use frontend\controllers\BaseController;
use yii\rest\Controller;

/**
 * Default controller for the `file-manager` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return "Welcome";
    }
}
