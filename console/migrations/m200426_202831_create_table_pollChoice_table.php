<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%table_pollChoice}}`.
 */
class m200426_202831_create_table_pollChoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%table_pollChoice}}', [
            'id' => $this->primaryKey(),
            'choice_body' => $this->string(),
            'poll_id' => $this->integer(),
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
        $this->dropTable('{{%table_pollChoice}}');
    }
}
