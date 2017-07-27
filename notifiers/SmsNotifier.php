<?php

namespace app\notifiers;


use Yii;
use app\components\BaseNotifier;

/**
 * Класс для отправки SMS-сообщения
 */
class SmsNotifier extends BaseNotifier
{
    /**
     * Объект-обертка над CURL
     * @var \linslin\yii2\curl\Curl;
     */
    protected $curl;

    /**
     * Адрес, куда стучаться
     * @var string
     */
    public $apiAddress = "http://smspilot.ru/api.php";

    /**
     * Ключ API
     * @var string
     */
    public $apiKey = "XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ";

    /**
     * Предпочтительный формат ответа
     * @var [type]
     */
    public $formatResponse = "json";


    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->curl = new \linslin\yii2\curl\Curl;
    }

    /**
     * API Принимает телефон только в виде цифр.
     * Преобразовываем телефон к нужному формату
     * @return void
     */
    protected function normalizePhone()
    {
        $this->target = preg_replace("/\D/", "", $this->target);
    }

    /**
     * @inheritDoc
     */
    public function send() : bool
    {
        $this->normalizePhone();
        $response = $this->curl->setGetParams([
            'send' => $this->message,
            'to' => $this->target,
            "from" => Yii::$app->params['sitename'],
            "apiKey" => $this->apiKey,
            'format' => $this->formatResponse,
         ])
        ->get($this->apiAddress);

        $response = json_decode($response);

        return !(bool) $response->error;
    }
}
