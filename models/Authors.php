<?php

namespace app\models;

use app\models\relations\BookAuthor;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 *
 * @property BookAuthor[] $bookAuthors
 * @property Books[] $books
 */
class Authors extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * Получить 10 авторов, лидирующих по количеству книг за year год
     * @param  int $year    Год для выборки
     * @return array
     */
    public static function findTopByYear(int $year) : array
    {
        $relationTable = BookAuthor::tableName();
        $booksTable = Books::tableName();

        $subQuery = BookAuthor::find()
            ->select(["$relationTable.author_id", "COUNT(id) AS bookCount"])
            ->join("INNER JOIN", $booksTable, "$relationTable.book_id = " . $booksTable.".id")
            ->where("$booksTable.year = $year")
            ->groupBy("$relationTable.author_id");

        return self::find()
            ->join("INNER JOIN", ['topList' => $subQuery], self::tableName().".id = topList.author_id")
            ->orderBy(["topList.bookCount" => SORT_DESC])
            ->limit(10)
            ->all();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
        ];
    }

    /**
     * Возвращает полное имя автора
     * @return string
     */
    public function getName() : string
    {
        return vsprintf("%s %s%s", [
            $this->first_name,
            $this->middle_name ? $this->middle_name . " " : null,
            $this->last_name
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors() : \yii\db\ActiveQuery
    {
        return $this->hasMany(BookAuthor::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks() : \yii\db\ActiveQuery
    {
        return $this->hasMany(Books::className(), ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }
}
