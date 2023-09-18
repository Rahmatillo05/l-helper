<?php

namespace frontend\modules\file\controllers;

use frontend\controllers\BaseController;
use frontend\modules\file\models\File;
use frontend\modules\file\models\FileUpload;
use Yii;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

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

    /**
     * @throws MethodNotAllowedHttpException
     */
    public function actionUpload()
    {
        $model = new FileUpload();
        if ($this->request->isPost) {
            $files = UploadedFile::getInstancesByName('files');
            return $model->upload($files);
        }
        throw new MethodNotAllowedHttpException();
    }
}