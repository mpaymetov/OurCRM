<?php

namespace app\service;

use Yii;
use app\models\UserSearch;
use yii\data\ArrayDataProvider;

class UserService
{
    public function actionUserIndexRequest()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$dataModels = [];
        $dataModels = $dataProvider->getModels();

        $dataProvider = new ArrayDataProvider([
            'allModels'=> $dataModels,
        ]);*/

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

    public function GetManagerList($idDepartment)
    {
        $arr = (new UserSearch())->GetManagerList($idDepartment);
        $keys = [
            'id_user',
            'first_name',
            'second_name'
        ];

        $result = [];

        foreach ($arr as $item) {
            $curr = [];
            foreach ($keys as $key) {
                if(key_exists($key, $item)) {
                    $curr[$key] = $item[$key];
                }
            }
            if($curr) {
                array_push($result, $curr);
            }
        }

        $list = [];
        foreach ($result as $item) {
            $list[(int)$item['id_user']] = $item['first_name'] . ' ' . $item['second_name'];
        }

        return $list;
    }

}