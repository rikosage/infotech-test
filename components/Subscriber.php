<?php

namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Класс для отправки писем.
 */
class Subscriber extends Component
{

    /**
     * Тема письма
     * @var string
     */
    public $subject;

    /**
     * Сообщение
     * @var string
     */
    public $message;

    /**
     * Email для отправки
     * @var string
     */
    public $email;

    /**
     * Отправка сообщения
     * @return bool TRUE, если сообщение отправлено
     */
    public function send() : bool
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params["adminEmail"])
            ->setTo($this->email)
            ->setSubject($this->subject)
            ->setTextBody($this->message)
            ->send();
    }
}
