<?php

namespace app\models;

use Yii;

use app\behaviors\SaveImageBehavior;
use app\models\relations\BookAuthor;
use yii\db\IntegrityException;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $title
 * @property integer $year
 * @property string $description
 * @property string $isbn
 * @property string $image
 *
 * @property BookAuthor[] $bookAuthors
 * @property Authors[] $authors
 */
class Books extends \yii\db\ActiveRecord
{

    public $author_ids;
    public $imageFile;

    /**
     * @inheritDoc
     */
    public function behaviors() : array
    {
        return [
            'saveImage' => [
                'class' => SaveImageBehavior::className(),
                'attribute' => "image",
                'imageAttribute' => "imageFile",
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() : string
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['title', 'year', 'isbn', 'author_ids'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() : array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'Isbn',
            'image' => 'Обложка',
            'author_ids' => 'Авторы',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->author_ids = $this->authors;
        return parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        foreach ($this->author_ids as $author_id) {
            $relation = new BookAuthor;
            $relation->book_id = $this->id;
            $relation->author_id = $author_id;
            try {
                $relation->save();
            } catch (IntegrityException $e) {
                return parent::afterSave($insert, $changedAttributes);
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Authors::className(), ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }
}
