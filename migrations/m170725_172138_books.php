<?php

use yii\db\Migration;
use yii\db\Schema;

class m170725_172138_books extends Migration
{
    const TABLE_NAME = "books";

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . " NOT NULL",
            'year' => Schema::TYPE_INTEGER . " NOT NULL",
            'description' => Schema::TYPE_TEXT,
            'isbn' => Schema::TYPE_STRING . " NOT NULL",
            'image' => Schema::TYPE_STRING,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
