<?php

namespace app\interfaces;

interface NotifierInterface
{
    /**
     * Отправка сообщения
     * @return bool TRUE, если сообщение отправлено
     */
    public static function send() : bool;
}
