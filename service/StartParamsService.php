<?php

namespace app\service;

use Yii;
use app\models\StateCheck;

class StartParamsService
{

    public function takeStartParams($model)
    {
        $request = Yii::$app->request;
        if ($model->version == null) {
            $model->version = 0;
        }
        if (property_exists($model, 'is_active')) {
            if ($model->is_active == null) {
                $model->is_active = 0;
            }
        }
        if (property_exists($model, 'id_user')) {
            if ($model->id_user == null) {
                $model->id_user = Yii::$app->user->identity->id_user;
            }
        }
        if (property_exists($model, 'version')) {
            echo("in property");
            if ($model->version == null) {
                $model->version = 1;
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
            case 'serviceset':
                $this->takeStartServicesetParam($model, $request);
                return $model;
                break;
            case 'person':
                $this->takeStartPersonParam($model, $request);
                return $model;
                break;
            default:
                return false;
        }
    }

    public function takeStartEventParam($model, $request)
    {
        $model->is_active = 1;
        $model->id_doer = 0;
        $model->id_user = Yii::$app->user->identity->id_user;
        $model->id_link = $request->get('id_link');
        $model->link = $request->get('link');
    }

    public function takeStartProjectParam($model, $request)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
        $client_id = $request->get('id_client');
        $model->id_client = $client_id;
        $model->creation_date = date("Y-m-d");
    }

    public function takeStartClientParam($model, $request)
    {
        var_dump('in start params');
        $model->id_user = Yii::$app->user->identity->id_user;
        $model->created = date("Y-m-d");
    }

    public function takeStartPersonParam($model, $request)
    {
        $client_id = $request->get('id_client');
        $model->id_client = $client_id;
    }

    public function takeStartServicesetParam($model, $request)
    {
        $stateName = new StateCheck();
        $model->id_state = $stateName::MakeContact;
        $model->creation_date = date("Y-m-d");
        $model->is_open = 1;
    }

}