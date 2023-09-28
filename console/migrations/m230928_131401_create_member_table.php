<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%member}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%organization}}`
 * - `{{%user}}`
 * - `{{%class}}`
 * - `{{%user}}`
 */
class m230928_131401_create_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%member}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer(),
            'user_id' => $this->integer(),
            'class_id' => $this->integer(),
            'author_id' => $this->integer(),
            'full_name' => $this->string(),
            'address' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'member_type' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        // creates index for column `organization_id`
        $this->createIndex(
            '{{%idx-member-organization_id}}',
            '{{%member}}',
            'organization_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-member-organization_id}}',
            '{{%member}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-member-user_id}}',
            '{{%member}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-member-user_id}}',
            '{{%member}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `class_id`
        $this->createIndex(
            '{{%idx-member-class_id}}',
            '{{%member}}',
            'class_id'
        );

        // add foreign key for table `{{%class}}`
        $this->addForeignKey(
            '{{%fk-member-class_id}}',
            '{{%member}}',
            'class_id',
            '{{%classes}}',
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-member-author_id}}',
            '{{%member}}',
            'author_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-member-author_id}}',
            '{{%member}}',
            'author_id',
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
            '{{%fk-member-organization_id}}',
            '{{%member}}'
        );

        // drops index for column `organization_id`
        $this->dropIndex(
            '{{%idx-member-organization_id}}',
            '{{%member}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-member-user_id}}',
            '{{%member}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-member-user_id}}',
            '{{%member}}'
        );

        // drops foreign key for table `{{%class}}`
        $this->dropForeignKey(
            '{{%fk-member-class_id}}',
            '{{%member}}'
        );

        // drops index for column `class_id`
        $this->dropIndex(
            '{{%idx-member-class_id}}',
            '{{%member}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-member-author_id}}',
            '{{%member}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-member-author_id}}',
            '{{%member}}'
        );

        $this->dropTable('{{%member}}');
    }
}
