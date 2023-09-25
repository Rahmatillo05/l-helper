<?php

namespace common\models\book;

use common\models\category\DataCategory;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book_category".
 *
 * @property int $id
 * @property int|null $data_category_id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property DataCategory $dataCategory
 */
class BookCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['data_category_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['data_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string'],
            [['data_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataCategory::class, 'targetAttribute' => ['data_category_id' => 'id']],
        ];
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
     * Gets query for [[DataCategory]].
     *
     * @return ActiveQuery
     */
    public function getDataCategory(): ActiveQuery
    {
        return $this->hasOne(DataCategory::class, ['id' => 'data_category_id']);
    }
}
