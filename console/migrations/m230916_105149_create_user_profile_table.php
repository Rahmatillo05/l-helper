<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m230916_105149_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'address' => $this->string(),
            'birth_date' => $this->integer(),
            'bio' => $this->text(),
            'social_accounts' => $this->json(),
        ]);
        $this->addForeignKey('fk-to-user-from-user_profile', 'user_profile', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-to-user-from-user_profile', 'user_profile');
        $this->dropTable('{{%user_profile}}');
    }
}
