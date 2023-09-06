<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_auth}}`.
 */
class m230906_042736_create_user_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_auth}}', [
            'id' => $this->primaryKey(),
            'verification_code' => $this->integer(),
            'token' => $this->string(),
            'code_expiration_date' => $this->integer(),
            'token_expiration_date' => $this->integer(),
            'user_id' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk-to-user-from-user_auth', 'user_auth', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-to-user-from-user_auth', 'user_auth');
        $this->dropTable('{{%user_auth}}');
    }
}
