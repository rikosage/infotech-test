<?php

namespace app\components;

use yii\base\Component;

/**
 * Класс для отправки писем.
 */
class BaseNotifier extends Component implements \app\interfaces\NotifierInterface
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

}
