<?php

namespace app\models;

use app\behaviors\ImageModelBehavior;
use app\models\relations\BookAuthor;

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
    /**
     * Вспомогательное свойство для списка авторов
     * @var array
     */
    public $author_ids;

    /**
     * Вспомогательное свойство для загрузки изображения
     * @var string
     */
    public $imageFile;

    /**
     * @inheritDoc
     */
    public function behaviors() : array
    {
        return [
            'imageModel' => [
                'class' => ImageModelBehavior::className(),
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
            [['year'], 'integer', 'min' => 0, 'max' => date("Y")],
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
            'authors' => 'Авторы',
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
     * После сохранения обновляем отношения с авторами
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relations = BookAuthor::find()->all();

        foreach ($this->bookAuthors as $relation) {
            if (!in_array($relation->author_id, $this->author_ids)) {
                $relation->delete();
            }
        }

        foreach ($this->author_ids as $author_id) {
            $relation = new BookAuthor;
            $relation->book_id = $this->id;
            $relation->author_id = $author_id;
            $relation->save();
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
