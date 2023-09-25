<?php

namespace frontend\modules\file\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $file
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $ext
 * @property int|null $size
 * @property string|null $path
 * @property string|null $domain
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $user_id
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class
          ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['description', 'path', 'domain'], 'string'],
            [['size', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['title', 'ext', 'file', 'slug'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'file' => 'File',
            'slug' => 'Slug',
            'description' => 'Description',
            'ext' => 'Ext',
            'size' => 'Size',
            'path' => 'Path',
            'domain' => 'Domain',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }

    public function fields(): array
    {
        return ArrayHelper::merge(parent::fields(), [
           'thumbs' 
        ]);
    }
    
    public function getDist(): string
    {
        return "{$this->path}/{$this->file}";
    }

    public function getThumbs(): array
    {
        $thumbs = Yii::$app->params['thumbs'];
        $thumbsImage = [];
        foreach ($thumbs as $key => $val){
            $slug = $val['slug'];
            $thumbsImage[$key]['src'] = "{$this->domain}{$this->path}/{$this->slug}_$slug.{$this->ext}";
            $thumbsImage[$key]['path'] = "{$this->path}/{$this->slug}_$slug.{$this->ext}";
        }
        $thumbsImage['original']['src'] = "{$this->domain}{$this->path}/{$this->slug}.{$this->ext}";
        $thumbsImage['original']['path'] = "{$this->path}/{$this->slug}.{$this->ext}";
        return $thumbsImage;
    }
}
