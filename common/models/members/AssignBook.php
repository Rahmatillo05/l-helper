<?php

namespace common\models\members;

use common\models\book\Book;
use common\models\organization\Organization;
use common\models\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "assign_book".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $author_id
 * @property int|null $user_id
 * @property int|null $organization_id
 * @property int|null $member_id
 * @property int|null $amount
 * @property int|null $start
 * @property int|null $end
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property Book $book
 * @property Member $member
 * @property Organization $organization
 * @property User $user
 */
class AssignBook extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'assign_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['book_id', 'author_id', 'user_id', 'organization_id', 'member_id', 'amount', 'start', 'end', 'status', 'created_at', 'updated_at'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'author_id' => 'Author ID',
            'user_id' => 'User ID',
            'organization_id' => 'Organization ID',
            'member_id' => 'Member ID',
            'amount' => 'Amount',
            'start' => 'Start',
            'end' => 'End',
            'status' => 'Status',
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
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Book]].
     *
     * @return ActiveQuery
     */
    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[Member]].
     *
     * @return ActiveQuery
     */
    public function getMember(): ActiveQuery
    {
        return $this->hasOne(Member::class, ['id' => 'member_id']);
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

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
