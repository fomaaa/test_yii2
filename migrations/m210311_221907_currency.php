<?php

use yii\db\Migration;

/**
 * Class m210311_221907_currency
 */
class m210311_221907_currency extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->unique()->notNull(),
            'rate' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210311_221907_currency cannot be reverted.\n";
        $this->dropTable('currency');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_221907_currency cannot be reverted.\n";

        return false;
    }
    */
}
