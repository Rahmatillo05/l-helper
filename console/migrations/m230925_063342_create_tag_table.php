<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m230925_063342_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'data_category_id' => $this->integer(),
            'name' => $this->string()
        ]);
        $this->addForeignKey('fk-to-data_category', 'tag', 'data_category_id', 'data_category', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-to-data_category', 'tag');
        $this->dropTable('{{%tag}}');
    }
}
