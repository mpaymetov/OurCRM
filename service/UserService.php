<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.11.2018
 * Time: 14:42
 */

namespace app\service;

use Yii;
use app\models\User;
use app\models\UserSearch;

class UserService
{

    public function actionIndexRequest()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }
}