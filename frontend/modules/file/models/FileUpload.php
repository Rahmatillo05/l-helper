<?php

namespace frontend\modules\file\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\ServerErrorHttpException;

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
        if (count($files) > 0) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = [];
                foreach ($files as $file) {
                    $db_file = new File();
                    $db_file->slug = Yii::$app->security->generateRandomString(20);
                    $db_file->file = $db_file->slug . ".$file->extension";
                    $db_file->title = $file->name;
                    $db_file->description = $file->name;
                    $db_file->ext = $file->extension;
                    $db_file->user_id = $user_id;
                    $db_file->path = $folder;
                    $db_file->domain = Yii::$app->params['domain'];
                    $db_file->size = $file->size;
                    if ($file->saveAs("$path/$db_file->file") && $db_file->save()) {
                        $data[] = $db_file->id;
                        $this->createThumbs($db_file);
                        continue;
                    }
                    throw new ServerErrorHttpException("Fayllar saqlanmadi");
                }
                $transaction->commit();
                return ['status' => 200, 'message' => "Barcha fayllar saqlandi!", 'data' => $data];
            } catch (Exception $exception) {
                $transaction->rollBack();
                return ['status' => $exception->getCode(), 'message' => $exception->getMessage()];
            }
        }

        Yii::$app->response->statusCode = 400;
        return ['status' => 400, 'message' => "Bironta ham fayl yuklanmagan!"];
    }

    public function createThumbs(File $file): ?bool
    {
        $origin = $file->getDist();
        $origin_path = str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias('@frontend') . "/web$origin");
        $thumbs = Yii::$app->params['thumbs'];
        foreach ($thumbs as $thumb) {
            $width = $thumb['w'];
            $quality = $thumb['q'];
            $slug = $thumb['slug'];
            $newFile = "{$file->path}/{$file->slug}_{$slug}.{$file->ext}";
            $newFileDist = Yii::getAlias('@frontend') . "/web$newFile";
            $img = Image::getImagine()->open(Yii::getAlias($origin_path));
            $size = $img->getSize();
            $ratio = $size->getWidth() / $size->getHeight();
            $height = round($width / $ratio);
            Image::thumbnail($origin_path, $width, $height)->save(Yii::getAlias($newFileDist), ['quality' => $quality]);
        }
        return true;
    }
}