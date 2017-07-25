<?php

namespace app\components;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Базовый контроллер, от которого полагается наследовать остальные контроллеры
 */
class BaseController extends Controller
{

    /**
     * Стандартные экшены
     * @var array
     */
    protected $actions = ['create', 'index', "view", 'update', 'delete'];

    /**
     * Получаем список стандартных правил доступа.
     * Предполагается, что в наследниках переопределяется через array_merge при необходимости
     * @return array
     */
    protected function getAccessRules() : array
    {
        $rules = [
            [
            'allow' => false,
            'roles' => ['?'],
            ]
        ];

        foreach ($this->actions as $action) {
            $permission = ($action === "index" || $action == "view") ? "read" : $action;

            $rules[] = [
                'allow' => true,
                'actions' => [$action],
                'roles' => [sprintf("%s_%s", $this->id, $permission)],
            ];
        }

        return $rules;
    }

    /**
     * Выполняет поиск модели $className
     * Если модель не найдена - бросает 404
     * @param int $id
     * @return \yii\db\ActiveRecord Искомая модель
     * @throws NotFoundHttpException Если модель не найдена
     */
    protected function findModel(string $className, $id) : \yii\db\ActiveRecord
    {
        if (($model = $className::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
