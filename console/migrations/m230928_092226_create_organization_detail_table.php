<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization_detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%organization}}`
 * - `{{%user}}`
 */
class m230928_092226_create_organization_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable('{{%organization_detail}}', [
            'organization_id' => $this->integer(),
            'user_id' => $this->integer(),
            'address' => $this->string(),
            'description'  => $this->text(),
            'coordinates' => $this->string(),
            'social_link' => $this->json()
        ]);

        // creates index for column `organization_id`
        $this->createIndex(
            '{{%idx-organization_detail-organization_id}}',
            '{{%organization_detail}}',
            'organization_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-organization_detail-organization_id}}',
            '{{%organization_detail}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-organization_detail-user_id}}',
            '{{%organization_detail}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-organization_detail-user_id}}',
            '{{%organization_detail}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-organization_detail-organization_id}}',
            '{{%organization_detail}}'
        );

        // drops index for column `organization_id`
        $this->dropIndex(
            '{{%idx-organization_detail-organization_id}}',
            '{{%organization_detail}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-organization_detail-user_id}}',
            '{{%organization_detail}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-organization_detail-user_id}}',
            '{{%organization_detail}}'
        );

        $this->dropTable('{{%organization_detail}}');
    }
}
