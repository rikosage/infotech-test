<?php

namespace app\models\forms;

use yii\base\Model;

/**
 * Модель для формы топ-списка авторов
 */
class TopAuthorsListForm extends Model
{
    public $year;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['year'], 'required'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'year' => "Год выпуска книг",
        ];
    }
}
