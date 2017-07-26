<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

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

    public function attributeLabels()
    {
        return [
            'year' => "Год выпуска книг",
        ];
    }
}
