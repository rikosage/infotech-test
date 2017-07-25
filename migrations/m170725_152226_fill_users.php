<?php

use yii\db\Migration;

class m170725_152226_fill_users extends Migration
{

    const TABLE_NAME = "users";

    private $userList = [
        [
            'username' => "user_with_phone",
            'password' => "123456a",
            'phone' => "+7-415-910-73-24",
            'email' => "user@email.domain",
        ],
        [
            'username' => "simple_user",
            'password' => '123456a',
            'email' => "simple@email.domain"
        ],
        [
            'username' => 'moderator',
            'password' => '123456a',
            'email' => 'moder@email.domain'
        ]
    ];

    public function safeUp()
    {
        foreach ($this->userList as $user) {
            $user['password'] = Yii::$app->security->generatePasswordHash($user['password']);
            $user['accessToken'] = $user['username'] . "-token";
            $user['authKey'] = Yii::$app->security->generateRandomString();

            $this->insert(self::TABLE_NAME, $user);
        }

    }

    public function safeDown()
    {
        $this->delete(self::TABLE_NAME);
    }
}
