<?php

namespace app\components;

use yii\web\Controller;

class BaseController extends Controller
{

    protected $actions = ['create', 'index', 'update', 'delete'];

    protected function getAccessRules()
    {
        $rules = [
            [
            'allow' => false,
            'roles' => ['?'],
            ]
        ];

        foreach ($this->actions as $action) {
            $permission = $action === "index" ? "read" : $action;

            $rules[] = [
                'allow' => true,
                'actions' => [$action],
                'roles' => [sprintf("%s_%s", $this->id, $permission)],
            ];
        }

        return $rules;
    }
}
