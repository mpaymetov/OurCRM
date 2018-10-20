<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SecurityController extends Controller
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
        if (!property_exists($model, 'id_client')) {
            return true;
        } else {
            return false;
        }
    }

    public function validateCreateClientParam($model)
    {
        return $model;
    }

    public function takeStartParams($model)
    {
        $request = Yii::$app->request;
        if (property_exists($model, 'version')) {
            if ($model->version == null) {
                $model->version = 0;
            }
        }
        if (property_exists($model, 'is_active')) {
            if ($model->is_active == null) {
                $model->is_active = 0;
            }
        }
        switch ($model->tableName()) {
            case 'event':
                $this->takeStartEventParam($model, $request);
                return $model;
                break;
            case 'project':
                $this->takeStartProjectParam($model, $request);
                return $model;
                break;
            case 'client':
                $this->takeStartClientParam($model, $request);
                return $model;
                break;
            default:
                return false;
        }
    }

    public function takeStartEventParam($model, $request)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
        $link_id = $request->get('id_link');
        $link = $request->get('link');
        $model->link = $link;
        $model->id_link = $link_id;
    }

    public function takeStartProjectParam($model, $request)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
        $client_id = $request->get('id_client');
        $model->id_client = $client_id;
    }

    public function takeStartClientParam($model)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
    }

    public function test($model, $request)
    {

    }
}
