<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 06.11.2018
 * Time: 19:45
 */

namespace app\service;

use app\models\Person;
use app\models\Client;
use Yii;

class DataValidateService
{
    private $roleService;

    public function __construct()
    {
        $this->setRoleService(new RoleService());
    }

    public function setRoleService($roleUserService)
    {
        $this->roleService = $roleUserService;
    }

    public function checkElemAvailable($model)
    {
        if ($model->tableName() == 'person') {
            if ($this->validateCreatePersonParams($model)) {
                return true;
            };
        }
        if ($model->tableName() == 'serviceset') {
            if ($this->validateServisesetParam($model)) {
                return true;
            }
        } else {
            $creator = $model->id_user;
            if ($creator == Yii::$app->user->identity->id_user ||
                $this->roleService->getRole(Yii::$app->user->identity->id_user >= 2)) //todo rbac
                return true;
        }
    }


    public function dataControl($model)
    {
        if ($this->checkElemAvailable($model)) {
            if ($this->validateParams($model)) {
                return $model;
            }
        } else {
            return false;
        }
    }

    public function validateParams($model)
    {
        if ($model->validate()) {
            return true;
        } else {
            return false;
        }
    }

    public function validateServisesetParam($model)
    {
        if (Project::findOne($model->id_project)->id_user == Yii::$app->user->identity->id_user) {
            return true;
        }
        return false;
    }
}