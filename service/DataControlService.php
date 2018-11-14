<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 06.11.2018
 * Time: 19:45
 */

namespace app\service;

use Yii;

class DataControlService
{
    public function init()
    {

    }

    public function dataControl($model)
    {
        if ($this->compareUserId($model)) {
            if ($this->checkReferer($model)) {
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
                    default:
                        return false;
                }
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

    public function checkReferer($model)
    {
        $tableName = 'id_' . $model->tableName();
        $referer = Yii::$app->request->getReferrer();
        $str = stristr($referer, 'id=');
        $result = substr($str, 3);
        if ($model->{$tableName} == $result) {
            return true;
        } else {
            return false;
        }


        $model_name = $model->tableName();
        $session = Yii::$app->session;
        $saved_id = $session->get('id_' . $model);
        if ($model->{$tableName} == $saved_id || $model->id_event == null) {
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
       /* if (!property_exists($model, 'id_client')) {
            return true;
        } else {
            return false;
        } */
       //todo решить необходимость присутствия id клиента в проекте
        return true;
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
}