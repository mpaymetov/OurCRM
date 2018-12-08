<?php

namespace app\service;

use Yii;
use app\models\StateCheck;
use app\service\SessionUtility;

class StartParamsService
{

    public function init()
    {
        $this->getString();
    }

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
            if($model->id_user == null)
            {
                $model->id_user =  Yii::$app->user->identity->id_user;
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
        $model->creation_date = date("Y-m-d");
    }

    public function takeStartClientParam($model, $request)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
        $model->created = date("Y-m-d");
    }

    public function takeStartPersonParam($model, $request)
    {

    }

    public function takeStartServicesetParam($model, $request)
    {
        $stateName = new StateCheck();
        $session = new SessionUtility();
        $model->id_project = $session->GetSessionElem('id_project');
        $model->id_state = $stateName::MakeContact;
        $model->creation_date = date("Y-m-d");
        $model->is_open = 1;
    }
}