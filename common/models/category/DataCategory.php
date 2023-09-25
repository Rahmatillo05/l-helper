<?php

namespace common\models\category;

use common\models\book\BookCategory;
use common\models\categories\BlogCategory;
use common\models\tag\Tag;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "data_category".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property BlogCategory[] $blogCategories
 * @property BookCategory[] $bookCategories
 * @property Tag[] $tags
 */
class DataCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'data_category';
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
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BlogCategories]].
     *
     * @return ActiveQuery
     */
    public function getBlogCategories(): ActiveQuery
    {
        return $this->hasMany(BlogCategory::class, ['data_category_id' => 'id']);
    }

    /**
     * Gets query for [[BookCategories]].
     *
     * @return ActiveQuery
     */
    public function getBookCategories(): ActiveQuery
    {
        return $this->hasMany(BookCategory::class, ['data_category_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return ActiveQuery
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['data_category_id' => 'id']);
    }
}
