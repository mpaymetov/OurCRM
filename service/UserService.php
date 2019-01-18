<?php

namespace app\service;

use Yii;
use app\models\UserSearch;
use app\forms\ViewForm;
use yii\data\ArrayDataProvider;

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

    public function actionUserViewRequest($id)
    {
        $user = UserService::findModel($id);
        $model = new ViewForm();

        $model->id = $user->id_user;
        $model->login = $user->login;
        $model->first_name = $user->first_name;
        $model->second_name = $user->second_name;
        $model->id_department = $user->id_department;
        $model->status = ((int)$user->status == 0) ? "Disabled" : "Enabled";
        $model->created_at = $user->created_at;
        $model->updated_at = $user->updated_at;
        $model->email = $user->email;
        $model->role = Yii::$app->authManager->getRole($model->login);

        return $model;
    }

    public function findLoginById($id)
    {
        $model = UserSearch::findOne($id);
        $name = $model->login;
        return $name;
    }

    public function findIdByLogin($login)
    {
        $model = User::findByLogin($login);
        $id = $model->id_user;
        return $id;
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

        if(!empty($arr)) {
            foreach ($arr as $item) {
                $curr = [];
                foreach ($keys as $key) {
                    if (key_exists($key, $item)) {
                        $curr[$key] = $item[$key];
                    }
                }
                if ($curr) {
                    array_push($result, $curr);
                }
            }
        }

        $list = [];
        foreach ($result as $item) {
            //$list[(int)$item['id_user']] = $item['first_name'] . ' ' . $item['second_name'];
            array_push($list, ['id' => (int)$item['id_user'], 'name' => $item['first_name'] . ' ' . $item['second_name']]);
        }

        return $list;
    }

    public function disableUser($id)
    {
        $user = UserSearch::findOne($id);
        $user->status = 0; //User::STATUS_DELETED;
        $user->save();
        return $user;
    }

    public function enableUser($id)
    {
        $user = UserSearch::findOne($id);
        $user->status = 10; //User::STATUS_ACTIVE;
        $user->save();
        return $user;
    }
}