<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%table_pollResults}}`.
 */
class m200426_202900_create_table_pollResults_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%table_pollResults}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer(),
            'poll_choice_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%table_pollResults}}');
    }
}
