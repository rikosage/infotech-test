<?php

namespace app\components;

use yii\base\Component;

/**
 * Класс для отправки SMS-сообщения
 */
class SmsSender extends Component
{
    /**
     * Сообщение
     * @var string
     */
    public $message;

    /**
     * Номер телефона
     * @var string
     */
    public $phone;

    public function send()
    {
        // Отправляем sms юзеру
    }
}
