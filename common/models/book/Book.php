<?php

namespace common\models\book;

use common\models\category\Category;
use common\models\organization\Organization;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int|null $category_id
 * @property int|null $author_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $image_id
 * @property int|null $status
 * @property int|null $is_top
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property BookAuthor $author
 * @property Category $category
 * @property Organization $organization
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'category_id', 'author_id', 'image_id', 'status', 'is_top', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organization_id', 'category_id', 'author_id', 'image_id', 'status', 'is_top', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookAuthor::class, 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
            'name' => 'Name',
            'description' => 'Description',
            'image_id' => 'Image ID',
            'status' => 'Status',
            'is_top' => 'Is Top',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(BookAuthor::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return ActiveQuery
     */
    public function getOrganization(): ActiveQuery
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
}
