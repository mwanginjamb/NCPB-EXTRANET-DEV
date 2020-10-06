<?php

use yii\db\Migration;

/**
 * Class m200426_205636__add_open_and_close_dates
 */
class m200426_205636__add_open_and_close_dates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%poll}}','startdate','int');
        $this->addColumn('{{%poll}}','enddate','int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200426_205636__add_open_and_close_dates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200426_205636__add_open_and_close_dates cannot be reverted.\n";

        return false;
    }
    */
}
