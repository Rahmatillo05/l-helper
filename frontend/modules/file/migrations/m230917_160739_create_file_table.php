<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m230917_160739_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'files' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text(),
            'ext'=> $this->string(),
            'size' => $this->integer(),
            'path' => $this->text(),
            'domain' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'user_id' => $this->integer()
        ]);
        $this->createIndex(
            'idx-files-users-user-id',
            '{{%file}}',
            '[[user_id]]'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}
