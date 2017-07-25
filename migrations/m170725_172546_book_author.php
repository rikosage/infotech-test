<?php

use yii\db\Migration;

use yii\db\Schema;

class m170725_172546_book_author extends Migration
{

    const TABLE_NAME = "book_author";
    const AUTHOR_TABLE = "authors";
    const BOOKS_TABLE = "books";

    /**
     * Создаем индекс и внешний ключ для таблицы books
     */
    private function setForeignKeyForBooks()
    {
        $this->createIndex("book_id-index", self::TABLE_NAME, "book_id");
        $this->addForeignKey(
            "book_author-book-fk",
            self::TABLE_NAME,
            'book_id',
            self::BOOKS_TABLE,
            'id',
            "CASCADE"
        );
    }

    /**
     * Создаем индекс и внешний ключ для таблицы authors
     */
    private function setForeignKeyForAuthors()
    {
        $this->createIndex("author_id-index", self::TABLE_NAME, "author_id");
        $this->addForeignKey(
            "book_author-author-fk",
            self::TABLE_NAME,
            'author_id',
            self::AUTHOR_TABLE,
            'id',
            "CASCADE"
        );
    }

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'book_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'author_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ]);
        $this->addPrimaryKey('book_author-pk', 'book_author', ['book_id', 'author_id']);

        $this->setForeignKeyForBooks();
        $this->setForeignKeyForAuthors();

    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170725_172546_book_author cannot be reverted.\n";

        return false;
    }
    */
}
