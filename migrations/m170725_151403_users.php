<?php

use yii\db\Migration;
use yii\db\Schema;

class m170725_151403_users extends Migration
{

    const TABLE_NAME = "users";

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . " NOT NULL",
            'password' => Schema::TYPE_STRING . " NOT NULL",
            'authKey' => Schema::TYPE_STRING . " NOT NULL",
            'accessToken' => Schema::TYPE_STRING . " NOT NULL",
            'phone' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
