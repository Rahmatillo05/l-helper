<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization_type}}`.
 */
class m230928_090651_create_organization_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(),
            'name' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->batchInsert('organization_type', [
            'name',
            'slug',
            'created_at',
            'updated_at',
        ],
            [
                ['Maktab', 'school', time(), time()],
                ['Ommaviy kutubxona', 'public_library', time(), time()],
                ['Kitob do\'koni', 'book_store', time(), time()]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organization_type}}');
    }
}
