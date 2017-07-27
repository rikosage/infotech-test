<?php

namespace app\notifiers;

use Yii;
use app\components\BaseNotifier;

/**
 * Класс для отправки писем.
 */
class EmailNotifier extends BaseNotifier
{
    /**
     * Тема письма
     * @var string
     */
    public $subject;

    /**
     * @inheritDoc
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
