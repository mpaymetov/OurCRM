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
                $this->roleService->getRole(Yii::$app->user->identity->id_user >= 2)) {
                return true;
            }
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
        };
    }

    public function validateCreatePersonParams($model)
    {
        return true;
        /*
        if (Client::findOne($model->id_client)->id_user == Yii::$app->user->identity->id_user) {
            return true;
        }
        return false;
 */
    }



    /*  public function dataControl($model)
      {
          if ($this->checkElemAvailable($model)) {
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
                      if ($this->validateCreatePersonParams($model)) {
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

      public function validateCreateClientParam($model)
      {
          if (!property_exists($model, 'name') && !property_exists($model, 'comment')) {
              return $model;
          }
          return false;
      }
  */
}