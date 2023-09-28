<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%organization}}`
 */
class m230928_092944_create_book_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer(),
            'full_name' => $this->string(),
            'nick' => $this->string(),
            'birth_date' => $this->integer(),
            'death_date' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
            'image_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `organization_id`
        $this->createIndex(
            '{{%idx-book_author-organization_id}}',
            '{{%book_author}}',
            'organization_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-book_author-organization_id}}',
            '{{%book_author}}',
            'organization_id',
            '{{%organization}}',
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
            '{{%fk-book_author-organization_id}}',
            '{{%book_author}}'
        );

        // drops index for column `organization_id`
        $this->dropIndex(
            '{{%idx-book_author-organization_id}}',
            '{{%book_author}}'
        );

        $this->dropTable('{{%book_author}}');
    }
}
