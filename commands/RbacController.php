<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    const USER_ROLE = "user";
    const GUEST_ROLE = "guest";

    private function createPermission(string $name, string $description)
    {
        $permission = Yii::$app->authManager->createPermission($name);
        $permission->description = $description;
        Yii::$app->authManager->add($permission);
    }

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

        echo "Created RBAC entities!\n";
    }

    public function actionRollback()
    {
        Yii::$app->authManager->removeAll();
        echo "All RBAC entities successfully removed!\n";
    }
}
