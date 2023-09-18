<?php

namespace frontend\modules\file\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $files
 * * @property string|null $description
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
            [['title', 'ext'], 'string'],
            [['files'], 'string']
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
}
