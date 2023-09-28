<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m230928_091421_add_organization_id_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'organization_id', $this->integer()->after('user_type'));
        $this->addForeignKey('fk-to-organization', 'user', 'organization_id', 'organization', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-to-organization', 'user');
        $this->dropColumn('{{%user}}', 'organization_id');
    }
}
