<?php

namespace frontend\modules\file\controllers;

use frontend\controllers\BaseController;
use frontend\modules\file\models\File;
use frontend\modules\file\models\FileUpload;
use Throwable;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FileController extends BaseController
{

    public $modelClass = File::class;

    public $defaultAction = 'files';

    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['delete'], $actions['update']);
        return $actions;
    }

    public function actionFiles(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => File::find(),
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }

    public function actionThumb($id)
    {
        $file = File::findOne($id);
        return (new FileUpload())->createThumbs($file);
    }

    /**
     * @throws MethodNotAllowedHttpException
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpload(): array|File
    {
        $model = new FileUpload();
        /* Create */
        if ($this->request->isPost) {
            $files = UploadedFile::getInstancesByName('files');
            try {
                return $model->upload($files);
            } catch (ServerErrorHttpException|Exception $e) {
                return ['status' => $e->getCode(), 'message' => $e->getMessage()];
            }
        }
        /* Create end */

        /* Update */
        if ($this->request->isPut || $this->request->isPatch) {
            $id = Yii::$app->request->post('id');
            if ($id) {
                $files = UploadedFile::getInstancesByName('files');
                if ($files) {
                    try {
                        return $model->update($files, $id);
                    } catch (ErrorException $exception) {
                        return ['status' => $exception->getCode(), 'message' => $exception->getMessage()];
                    } catch (NotFoundHttpException|ServerErrorHttpException|Exception $e) {
                        return ['status' => $e->getCode(), 'message' => $e->getMessage()];
                    }
                }
                return $model->findModel($id);
            }
            throw new BadRequestHttpException(" 'id' parametri berilamagan!");
        }
        /* Update End */
        throw new MethodNotAllowedHttpException();
    }

    /**
     * @throws Throwable
     * @throws ErrorException
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): bool|int
    {
        $model = new FileUpload();

        return $model->delete($id);
    }
}