<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 06.11.2018
 * Time: 19:45
 */

namespace app\service;

use app\models\Person;
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
        $creator = $model->id_user;
        if ($creator == Yii::$app->user->identity->id_user || //todo првоерка на доступнось!!!
            $this->roleService->getRole(Yii::$app->user->identity->id_user >= 2)) {
            return true;
        }
    }

    public function dataControl($model)
    {
        if ($this->compareUserId($model)) {
            switch ($model->tableName()) {
                case 'event':
                    if ($this->validateCreateEventParam($model)) {
                        return $model;
                    }
                    break;
                case 'project':
                    if ($this->validateCreateProjectParam($model)) {
                        return $model;
                    }
                    break;
                case 'client':
                    if ($this->validateCreateClientParam($model)) {
                        return true;
                    }
                    break;
                case 'user':
                    if ($this->validateCreateUserParam($model)) {
                        return $model;
                    }
                    break;
                case 'person':
                        if($this->validateCreateParams($model))
                        {
                            return $model;
                        }
                    break;
                default:
                    return false;
            }

        } else {
            return false;
        }
    }

    public function compareUserId($model)
    {
        if ($model->id_user == Yii::$app->user->identity->id_user) {
            return true;
        } else {
            return false;
        }
    }

    public function validateCreateEventParam($model)
    {
        if (!property_exists($model, 'link') && (!property_exists($model, 'id_link'))) {
            return true;
        } else {
            return false;
        }
    }

    public function validateCreateProjectParam($model)
    {
        if (!property_exists($model, 'id_client')) {
             return true;
         } else {
             return false;
         }
        //todo решить необходимость присутствия id клиента в проекте
    }

    public function validateCreateClientParam($model)
    {
        return $model;
    }

    public function validateCreateUserParam($model)
    {
        return $model;
    }

    public function validateServisesetParam($model)
    {
        if (Project::findOne($model->id_project)->id_user == Yii::$app->user->identity->id_user) {
            return true;
        };
    }

    public function validateCreateParams($model)
    {
        if(Person::findOne($model->id_user) == Yii::$app->user->identity->id_user);
        return true;
    }
}