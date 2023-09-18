<?php

namespace frontend\modules\file\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FileUpload extends Model
{
    public $files;

    public function rules(): array
    {
        return [
            [['files'], 'file', 'maxFiles' => 8, 'extensions' => ['jpg', 'jpeg', 'png']]
        ];
    }

    /**
     * @throws \yii\base\Exception
     * @throws ServerErrorHttpException
     */
    public function upload(array $files)
    {
        $y = date('Y');
        $m = date('m');
        $d = date('d');
        $h = date('H');
        $min = date('i');
        $user_id = Yii::$app->user->id;
        $folder = Url::base() . "/upload/$y/$m/$d/$h/$min";
        $path = Yii::getAlias('@frontend') . "/web$folder";
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (count($files) > 0) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($files as $file) {
                    /**
                     * @var UploadedFile $file
                     */
                    $db_file = new File();
                    $db_file->files = Yii::$app->security->generateRandomString(20) . ".$file->extension";
                    $db_file->title = $file->name;
                    $db_file->description = $file->name;
                    $db_file->ext = $file->extension;
                    $db_file->user_id = $user_id;
                    $db_file->path = "$folder/{$db_file->files}";
                    $db_file->domain = Yii::$app->params['domain'];
                    $db_file->size = $file->size;
                    if ($file->saveAs("$path/$db_file->files") && $db_file->save()) {
                        continue;
                    }
                    throw new ServerErrorHttpException("Fayllar saqlanmadi");
                }
                $transaction->commit();
                return ['status' => 200, 'message' => "Barcha fayllar saqlandi!"];
            } catch (Exception $exception) {
                $transaction->rollBack();
                return ['status' => $exception->getCode(), 'message' => $exception->getMessage()];
            }
        }

        Yii::$app->response->statusCode = 400;
        return ['status' => 400, 'message' => "Bironta ham fayl yuklanmagan!"];
    }
}