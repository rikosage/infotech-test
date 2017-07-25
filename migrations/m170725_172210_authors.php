<?php

use yii\db\Migration;
use yii\db\Schema;

class m170725_172210_authors extends Migration
{

    const TABLE_NAME = "authors";

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => Schema::TYPE_PK,
            'first_name' => Schema::TYPE_STRING . " NOT NULL",
            'last_name' => Schema::TYPE_STRING . " NOT NULL",
            'middle_name' => Schema::TYPE_STRING,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
