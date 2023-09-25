<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%data_category}}`.
 */
class m230925_062830_create_data_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%data_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $this->batchInsert('data_category', [
            'name',
            'created_at',
            'updated_at',
        ],
        [
            ['Yangilikllar', time(), time()],
            ['Postlar', time(), time()],
            ['Kitoblar', time(), time()]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%data_category}}');
    }
}
