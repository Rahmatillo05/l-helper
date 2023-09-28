<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_amount}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 */
class m230928_171858_create_book_amount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_amount}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'user_id' => $this->integer(),
            'amount' => $this->integer(),
            'comment' => $this->text(),
            'date' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-book_amount-book_id}}',
            '{{%book_amount}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-book_amount-book_id}}',
            '{{%book_amount}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-book_amount-user_id}}',
            '{{%book_amount}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-book_amount-user_id}}',
            '{{%book_amount}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-book_amount-book_id}}',
            '{{%book_amount}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-book_amount-book_id}}',
            '{{%book_amount}}'
        );
        $this->dropForeignKey(
            '{{%fk-book_amount-user_id}}',
            '{{%book_amount}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-book_amount-user_id}}',
            '{{%book_amount}}'
        );

        $this->dropTable('{{%book_amount}}');
    }
}
