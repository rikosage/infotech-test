<?php

namespace app\models\relations;

use app\models\Books;
use app\models\Authors;

/**
 * This is the model class for table "book_author".
 *
 * @property integer $book_id
 * @property integer $author_id
 *
 * @property Authors $author
 * @property Books $book
 */
class BookAuthor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() : string
    {
        return 'book_author';
    }

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
            [['book_id', 'author_id'], 'unique', 'targetAttribute' => ['book_id', "author_id"]],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() : array
    {
        return [
            'book_id' => 'Book ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor() : \yii\db\ActiveQuery
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook() : \yii\db\ActiveQuery
    {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }
}
