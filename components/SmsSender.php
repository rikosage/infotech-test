<?php

namespace app\components;

use yii\base\Component;

class SmsSender extends Component
{

    public $message;
    public $phone;

    public function send()
    {
        // Отправляем sms юзеру
    }
}
