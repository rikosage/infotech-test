<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

/**
 * Базовый класс для инициализации RBAC
 */
class RbacController extends Controller
{

    /**
     * Пользователь
     * @var string
     */
    const USER_ROLE = "user";

    /**
     * Гость
     * @var string
     */
    const GUEST_ROLE = "guest";

    /**
     * Создает право на действие
     * @param  string $name        Имя действия
     * @param  string $description Описание
     * @return void
     */
    private function createPermission(string $name, string $description)
    {
        $permission = Yii::$app->authManager->createPermission($name);
        $permission->description = $description;
        Yii::$app->authManager->add($permission);
    }

    /**
     * Устанавливает соответствие для роли и права.
     * Право будет получено как %$entity%_%action%
     * @param \yii\rbac\Role  $role     Роль
     * @param array           $entities Список сущностей, к которым привяжем
     * @param array           $actions  Список действий
     * @return void
     */
    private function setPermissionsForRoles(\yii\rbac\Role $role, array $entities, array $actions)
    {
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $name = sprintf("%s_%s", $entity, $action);
                $permission = Yii::$app->authManager->getPermission($name);
                Yii::$app->authManager->addChild($role, $permission);
            }
        }
    }

    /**
     * Устанавливает роли базовым пользователям
     * @return void
     */
    private function setRolesForUser()
    {
        $users = User::find()->all();
        foreach ($users as $user) {
            $roleName = $user->username === "moderator"
                ? self::USER_ROLE
                : self::GUEST_ROLE;

            $role = Yii::$app->authManager->getRole($roleName);
            Yii::$app->authManager->assign($role, $user->id);
        }
    }

    /**
     * Выполняет инициализацию RBAC и создает базовые сущности.
     * @return void
     */
    public function actionInit()
    {
        $this->createPermission("book_create",       "Create book");
        $this->createPermission("book_read",         "Read book");
        $this->createPermission("book_update",       "Update book");
        $this->createPermission("book_delete",       "Delete book");

        $this->createPermission("author_create",     "Create author");
        $this->createPermission("author_read",       "Read author");
        $this->createPermission("author_update",     "Update author");
        $this->createPermission("author_delete",     "Delete author");
        $this->createPermission("author_subscribe",  "Subscribe author");

        $user = Yii::$app->authManager->createRole(self::USER_ROLE);
        Yii::$app->authManager->add($user);
        $this->setPermissionsForRoles($user, ['book', 'author'], [
            'create', 'read', 'update', 'delete',
        ]);

        $guest = Yii::$app->authManager->createRole(self::GUEST_ROLE);
        Yii::$app->authManager->add($guest);
        $this->setPermissionsForRoles($guest, ['author'], ['read', 'subscribe']);
        $this->setPermissionsForRoles($guest, ['book'], ['read']);

        $this->setRolesForUser();

        echo "Created RBAC entities!\n";
    }



    /**
     * Выполняет откат сущностей RBAC
     * @return void
     */
    public function actionRollback()
    {
        Yii::$app->authManager->removeAll();
        echo "All RBAC entities successfully removed!\n";
    }
}
