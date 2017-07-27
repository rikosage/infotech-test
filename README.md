# Тестовый проект для Infotech

Проект основан на Yii2, шаблон Basic.

## Установка

Для установки проекта локально требуется проделать следующие действия:

1. Склонировать репозиторий: `git clone git@github.com:rikosage/infotech-test.git infotech-test`
2. Выполнить `composer update` в папке с проектом
3. Установить параметры доступы для БД в файле `@app/config/db.php`
4. Выполнить миграцию, инициализирующую RBAC: `php yii migrate/up --migrationPath=@yii/rbac/migrations`
5. Выполнить миграции проекта: `php yii migrate/up`
6. Выполнить инициализацию прав и ролей: `php yii rbac/init`.
7. Создать папку для изображений:
```bash
mkdir web/uploads
sudo chmod 777 web/uploads  
```

## Доступы

В базу данных по умолчанию добавляется три пользователя:
1. moderator
2. simple_user
3. user_with_phone

Пароль для всех пользователей: **123456a**

## Откат

При необходимости можно откатить приложение к изначальному виду:

1. Выполнить `yii php rbac/rollback`.
2. Выполнить `php yii migrate/down all --migrationPath=@yii/rbac/migrations`
3. Выполнить `php yii migrate/down all`
