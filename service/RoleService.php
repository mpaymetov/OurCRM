<?php

namespace app\service;

use app\controllers\SecurityController;
use Yii;
use app\models\Event;
use app\models\EventSearch;
use app\service\UserServise;
use app\service\StartParamsService;


class RoleService
{

    public static function getRole()
    {
        return Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id_user);
    }

}