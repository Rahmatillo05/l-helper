<?php

namespace frontend\modules\file\controllers;

use frontend\controllers\BaseController;
use frontend\modules\file\models\File;

class FileController extends BaseController
{

    public $modelClass = File::class;

    public $defaultAction = 'files';

    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['delete'], $actions['update']);
        return $actions;
    }

    public function actionFiles()
    {
        return "Hello";
    }

    public function actionUpload()
    {

    }
}