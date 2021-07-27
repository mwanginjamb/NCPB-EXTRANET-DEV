<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vendorUser}}`.
 */
class m210705_131431_add_verification_token_column_to_vendorUser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vendorUser}}', 'verification_token', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%vendorUser}}', 'verification_token');
    }
}
