<?php

namespace app\notifiers;

use app\components\BaseNotifier;

/**
 * Класс для отправки SMS-сообщения
 */
class SmsNotifier extends BaseNotifier
{
    /**
     * @inheritDoc
     */
    public function send() : bool
    {
        // Отправляем sms пользователю
        return true;
    }
}
