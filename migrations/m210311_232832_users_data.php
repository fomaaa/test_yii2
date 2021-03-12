<?php

use yii\db\Migration;
use app\models\User;
/**
 * Class m210311_232832_users_data
 */
class m210311_232832_users_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $users = array(
            [
                'login' => 'user1',
                'password' =>  Yii::$app->getSecurity()->generatePasswordHash(123456),
                'access_token' =>  'YdwvyEmDTKH-3fIU4muNCY6qw059eBr-Fbze3XDp'
            ],
            [
                'login' => 'user2',
                'password' =>  Yii::$app->getSecurity()->generatePasswordHash('123qwe'),
                'access_token' =>  'grZMtMb70LFf8YUUvjWROix37tF2h2nc5XgmvMZY'
            ]
        );

        foreach ($users as $key => $user)
        {
            $model = new User();
            $model->login = $user['login'];
            $model->password_hash = $user['password'];
            $model->access_token = $user['access_token'];

            $model->save(false);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210311_232832_users_data cannot be reverted.\n";
        $this->truncateTable('user');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210311_232832_users_data cannot be reverted.\n";

        return false;
    }
    */
}
