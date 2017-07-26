<?php

use yii\db\Migration;

use yii\db\Schema;

class m170726_193040_subscribe extends Migration
{

    const TABLE_NAME = "subscribe";
    const AUTHOR_TABLE = "authors";
    const USER_TABLE = "users";

    /**
     * Создаем индекс и внешний ключ для таблицы authors
     */
    private function setForeignKeyForAuthors()
    {
        $this->createIndex("book_id-index", self::TABLE_NAME, "author_id");
        $this->addForeignKey(
            "subscribe-author-fk",
            self::TABLE_NAME,
            'author_id',
            self::AUTHOR_TABLE,
            'id',
            "CASCADE"
        );
    }

    /**
     * Создаем индекс и внешний ключ для таблицы users
     */
    private function setForeignKeyForUsers()
    {
        $this->createIndex("book_id-index", self::TABLE_NAME, "user_id");
        $this->addForeignKey(
            "subscribe-user-fk",
            self::TABLE_NAME,
            'user_id',
            self::USER_TABLE,
            'id',
            "CASCADE"
        );
    }

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'user_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'author_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ]);
        $this->addPrimaryKey('subscribe-pk', self::TABLE_NAME, ['user_id', 'author_id']);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
