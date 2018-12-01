<?php

namespace app\service;

use Yii;
use app\models\UserSearch;

class UserService
{
    public function actionUserIndexRequest()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function findLoginById($id)
    {
        $model = UserSearch::findOne($id);
        $name = $model->login;
        return $name;
    }

    public function findModel($id)
    {
        return UserSearch::findOne($id);
    }
}