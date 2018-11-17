<?php

namespace app\commands;

use app\components\UserPermissions;
use Yii;
use yii\console\Controller;

/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');

        // запишем их в БД
        $auth->add($admin);
        $auth->add($manager);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        $createItem = $auth->createPermission('createItem');
        $createItem->description = 'Создание';

        $updateItem = $auth->createPermission('updateItem');
        $updateItem->description = 'Редактирование';

        // Запишем эти разрешения в БД
        $auth->add($viewAdminPage);
        $auth->add($updateItem);
        $auth->add($createItem);

        // Теперь добавим наследования. Для роли manager мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли manager и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($manager,$createItem);

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($manager,$updateItem);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $manager);

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($admin,$createItem);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $viewAdminPage);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль manager пользователю с ID 2
        $auth->assign($manager, 2);

        $auth->assign($admin, 3);
    }
}