<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_category}}`.
 */
class m230925_064758_create_book_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_category}}', [
            'id' => $this->primaryKey(),
            'data_category_id' => $this->integer(),
            'name' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $this->addForeignKey(
            'fk-to-data_category-from-book_category',
            'book_category',
            'data_category_id',
            'data_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-to-data_category-from-book_category', 'book_category');

        $this->dropTable('{{%book_category}}');
    }
}
