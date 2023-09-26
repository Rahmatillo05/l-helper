<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
class m230926_084326_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->text(),
            'content' => $this->text(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

            'author_id' => $this->integer(),
            'category_id' => $this->integer(),
            'data_category_id' => $this->integer()
        ]);
        $this->createIndex(
            '{{%idx-blog-author_id}}',
            '{{%blog}}',
            'author_id'
        );
        $this->addForeignKey('fk-to-user-from-blog', 'blog', 'author_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex(
            '{{%idx-blog-category_id}}',
            '{{%blog}}',
            'category_id'
        );
        $this->addForeignKey('fk-to-category-from-blog', 'blog', 'category_id', 'blog_category', 'id');

        $this->createIndex(
            '{{%idx-blog-data_category_id}}',
            '{{%blog}}',
            'data_category_id'
        );
        $this->addForeignKey('fk-to-data-category-from-blog', 'blog', 'data_category_id', 'data_category', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            '{{%idx-blog-author_id}}',
            '{{%blog}}'
        );
        $this->dropIndex(
            '{{%idx-blog-category_id}}',
            '{{%blog}}'
        );
        $this->dropIndex(
            '{{%idx-blog-data_category_id}}',
            '{{%blog}}'
        );
        $this->dropForeignKey(
            'fk-to-data-category-from-blog',
            'blog'
        );
        $this->dropForeignKey(
            'fk-to-category-from-blog',
            'blog'
        );
        $this->dropForeignKey(
            'fk-to-user-from-blog',
            'blog'
        );
        $this->dropTable('{{%blog}}');
    }
}
