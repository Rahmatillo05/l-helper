<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assign_book}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%organization}}`
 * - `{{%member}}`
 */
class m230928_172959_create_assign_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assign_book}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
            'user_id' => $this->integer(),
            'organization_id' => $this->integer(),
            'member_id' => $this->integer(),
            'amount' => $this->integer(),
            'start' => $this->integer(),
            'end' => $this->integer(),
            'status' => $this->smallInteger(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-assign_book-book_id}}',
            '{{%assign_book}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-assign_book-book_id}}',
            '{{%assign_book}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-assign_book-author_id}}',
            '{{%assign_book}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-assign_book-author_id}}',
            '{{%assign_book}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-assign_book-user_id}}',
            '{{%assign_book}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-assign_book-user_id}}',
            '{{%assign_book}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `organization_id`
        $this->createIndex(
            '{{%idx-assign_book-organization_id}}',
            '{{%assign_book}}',
            'organization_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-assign_book-organization_id}}',
            '{{%assign_book}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE'
        );

        // creates index for column `member_id`
        $this->createIndex(
            '{{%idx-assign_book-member_id}}',
            '{{%assign_book}}',
            'member_id'
        );

        // add foreign key for table `{{%member}}`
        $this->addForeignKey(
            '{{%fk-assign_book-member_id}}',
            '{{%assign_book}}',
            'member_id',
            '{{%member}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-assign_book-book_id}}',
            '{{%assign_book}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-assign_book-book_id}}',
            '{{%assign_book}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-assign_book-author_id}}',
            '{{%assign_book}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-assign_book-author_id}}',
            '{{%assign_book}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-assign_book-user_id}}',
            '{{%assign_book}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-assign_book-user_id}}',
            '{{%assign_book}}'
        );

        // drops foreign key for table `{{%organization}}`
        $this->dropForeignKey(
            '{{%fk-assign_book-organization_id}}',
            '{{%assign_book}}'
        );

        // drops index for column `organization_id`
        $this->dropIndex(
            '{{%idx-assign_book-organization_id}}',
            '{{%assign_book}}'
        );

        // drops foreign key for table `{{%member}}`
        $this->dropForeignKey(
            '{{%fk-assign_book-member_id}}',
            '{{%assign_book}}'
        );

        // drops index for column `member_id`
        $this->dropIndex(
            '{{%idx-assign_book-member_id}}',
            '{{%assign_book}}'
        );

        $this->dropTable('{{%assign_book}}');
    }
}
