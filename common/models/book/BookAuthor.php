<?php

namespace common\models\book;

use common\models\book\Book;
use common\models\organization\Organization;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book_author".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property string|null $full_name
 * @property string|null $nick
 * @property int|null $birth_date
 * @property int|null $death_date
 * @property int|null $status
 * @property int|null $image_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Book[] $books
 * @property Organization $organization
 */
class BookAuthor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['organization_id', 'birth_date', 'death_date', 'status', 'image_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['organization_id', 'birth_date', 'death_date', 'status', 'image_id', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'nick'], 'string', 'max' => 255],
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
            'full_name' => 'Full Name',
            'nick' => 'Nick',
            'birth_date' => 'Birth Date',
            'death_date' => 'Death Date',
            'status' => 'Status',
            'image_id' => 'Image ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['author_id' => 'id']);
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
