<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Subscriber extends Component
{

    public $subject;
    public $message;
    public $user;

    public function send()
    {
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params["adminEmail"])
            ->setTo($this->user->email)
            ->setSubject($this->subject)
            ->setTextBody($this->message)
            ->send();
    }
}
