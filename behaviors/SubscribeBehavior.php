<?php

namespace app\behaviors;

use Yii;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\components\Subscriber;
use app\components\SmsSender;

/**
 * Поведение, уведомляющее пользователей при появлении новой книги у автора
 */
class SubscribeBehavior extends Behavior
{

    public $userAttribute;
    public $modelAttribute;

    /**
     * @inheritDoc
     */
    public function events() : array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'sendEmailForUser',
        ];
    }

    public function sendEmailForUser()
    {
        var_dump($subscriber);exit;
        $subscriber = new Subscriber([
            'subject' => $subject,
            'message' => $message,
            'user' => Yii::$app->user,
        ]);


        if (Yii::$app->user->identity->phone) {
            (new SmsSender([
                'message' => $message,
                'phone' => Yii::$app->user->identity->phone,
            ]))->send();
        }
    }
}
