<?php

use yii\db\Migration;

/**
 * Class m210311_222032_user
 */
class m210311_222032_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(30)->unique()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'access_token' => $this->string(40)->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210311_222032_user cannot be reverted.\n";
        $this->dropTable('user');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_222032_user cannot be reverted.\n";

        return false;
    }
    */
}
