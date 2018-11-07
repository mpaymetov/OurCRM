<?php

namespace app\service;

use Yii;

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
        var_dump($model);
        $model->id_user = Yii::$app->user->identity->id_user;
        $client_id = $request->get('id_client');
        $model->id_client = $client_id;
    }

    public function takeStartClientParam($model, $request)
    {
        $model->id_user = Yii::$app->user->identity->id_user;
    }
}