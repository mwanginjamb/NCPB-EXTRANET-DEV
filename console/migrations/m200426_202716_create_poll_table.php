<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll}}`.
 */
class m200426_202716_create_poll_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll}}', [
            'id' => $this->primaryKey(),
            'resolution_id' =>$this->integer(),
            'poll_body' => $this->text(),
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
        $this->dropTable('{{%poll}}');
    }
}
