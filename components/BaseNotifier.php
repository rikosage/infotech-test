<?php

namespace app\components;

use yii\base\Component;

/**
 * Класс для отправки писем.
 */
abstract class BaseNotifier extends Component
{
    /**
     * Сообщение
     * @var string
     */
    public $message;

    /**
     * Email для отправки
     * @var string
     */
    public $target;

    /**
     * Отправка сообщения
     * @return bool TRUE, если сообщение отправлено
     */
    public function send() : bool;

}
