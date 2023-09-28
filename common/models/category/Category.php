<?php

namespace common\models\category;

use common\models\blog\Blog;
use common\models\book\Book;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $data_category_id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Blog[] $blogs
 * @property Book[] $books
 * @property DataCategory $dataCategory
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['data_category_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['data_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['data_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataCategory::class, 'targetAttribute' => ['data_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'data_category_id' => 'Data Category ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Blogs]].
     *
     * @return ActiveQuery
     */
    public function getBlogs(): ActiveQuery
    {
        return $this->hasMany(Blog::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[DataCategory]].
     *
     * @return ActiveQuery
     */
    public function getDataCategory(): ActiveQuery
    {
        return $this->hasOne(DataCategory::class, ['id' => 'data_category_id']);
    }
}
