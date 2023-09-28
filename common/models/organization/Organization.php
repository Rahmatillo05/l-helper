<?php

namespace common\models\organization;

use common\components\Detect;
use common\models\book\Book;
use common\models\book\BookAuthor;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 * @property OrganizationDetail[] $organizationDetails
 * @property User[] $users
 */
class Organization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status'], 'default', 'value' => Detect::ACTIVE],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return ActiveQuery
     */
    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['organization_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['organization_id' => 'id']);
    }

    /**
     * Gets query for [[OrganizationDetails]].
     *
     * @return ActiveQuery
     */
    public function getOrganizationDetails(): ActiveQuery
    {
        return $this->hasMany(OrganizationDetail::class, ['organization_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['organization_id' => 'id']);
    }
}
