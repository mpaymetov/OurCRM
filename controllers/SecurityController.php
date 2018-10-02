<?php

namespace app\controllers;

use Yii;
use yii\web\Request;

class SecurityController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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
                        if ($this->validateClientParam($model)) {
                            return true;
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

    public
    function compareUserId($model)
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
        if(!property_exists($model, 'id_client')){
                return true;
        } else {
            return false;
        }
    }

    public function takeStartParams($model)
    {
        $request = Yii::$app->request;
        if ($model->version == null) {
            $model->version = 0;
        }

        if ($model->is_active == null) {
            $model->version = 0;
        }

        $user_id = Yii::$app->user->identity->id_user;
        $model->id_user = $user_id;

        switch ($model->tableName()) {
            case 'event':
                if ($this->takeStartEventParam($model, $request)) {
                    return $model;
                }
                break;
            case 'project':
                if ($this->takeStartProjectParam($model, $request)) {
                    return $model;
                }
                break;
            case 'client':
                if ($this->takeStartClientParam($model, $request)) {
                    return true;
                }
                break;
            default:
                return false;
        }
    }

    public function takeStartEventParam($model, $request)
    {
        $link_id = $request->get('id_link');
        $link = $request->get('link');
        $model->link = $link;
        $model->id_link = $link_id;
    }

    public function takeStartProjectParam($model, $request)
    {
        $client_id = $request->get('id_client');
        $model->id_client = $client_id;
    }
}
