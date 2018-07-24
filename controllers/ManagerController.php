<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Manager;

class ManagerController extends Controller
{
    public function actionIndex()
    {
        $query = Manager::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $managers = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'managers' => $managers,
            'pagination' => $pagination,
        ]);
    }
}