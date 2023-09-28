<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%organization}}`
 * - `{{%book_category}}`
 * - `{{%book_author}}`
 */
class m230928_093507_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer(),
            'category_id' => $this->integer(),
            'author_id' => $this->integer(),
            'name' => $this->string(),
            'description' => $this->text(),
            'image_id' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
            'is_top' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        // creates index for column `organization_id`
        $this->createIndex(
            '{{%idx-book-organization_id}}',
            '{{%book}}',
            'organization_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-book-organization_id}}',
            '{{%book}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-book-category_id}}',
            '{{%book}}',
            'category_id'
        );

        // add foreign key for table `{{%book_category}}`
        $this->addForeignKey(
            '{{%fk-book-category_id}}',
            '{{%book}}',
            'category_id',
            '{{%book_category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-book-author_id}}',
            '{{%book}}',
            'author_id'
        );

        // add foreign key for table `{{%book_author}}`
        $this->addForeignKey(
            '{{%fk-book-author_id}}',
            '{{%book}}',
            'author_id',
            '{{%book_author}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%organization}}`
        $this->dropForeignKey(
            '{{%fk-book-organization_id}}',
            '{{%book}}'
        );

        // drops index for column `organization_id`
        $this->dropIndex(
            '{{%idx-book-organization_id}}',
            '{{%book}}'
        );

        // drops foreign key for table `{{%book_category}}`
        $this->dropForeignKey(
            '{{%fk-book-category_id}}',
            '{{%book}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-book-category_id}}',
            '{{%book}}'
        );

        // drops foreign key for table `{{%book_author}}`
        $this->dropForeignKey(
            '{{%fk-book-author_id}}',
            '{{%book}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-book-author_id}}',
            '{{%book}}'
        );

        $this->dropTable('{{%book}}');
    }
}
