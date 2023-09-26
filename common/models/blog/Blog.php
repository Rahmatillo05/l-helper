<?php

namespace common\models\blog;

use common\models\categories\BlogCategory;
use common\models\category\DataCategory;
use common\models\user\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property int|null $image_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $author_id
 * @property int|null $category_id
 * @property int|null $data_category_id
 *
 *
 * @property User $author
 * @property BlogCategory $category
 */
class Blog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'blog';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['image_id', 'status', 'created_at', 'updated_at', 'author_id', 'category_id'], 'default', 'value' => null],
            [['image_id', 'status', 'created_at', 'updated_at', 'author_id', 'category_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['data_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataCategory::class, 'targetAttribute' => ['data_category_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'image_id' => 'Image ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'data_category_id' => 'Data Category ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(BlogCategory::class, ['id' => 'category_id']);
    }

    public function getDataCategory(): ActiveQuery
    {
        return $this->hasOne(DataCategory::class, ['id' => 'data_category_id']);
    }
}
