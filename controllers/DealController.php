<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\service\DealService;
use yii\helpers\ArrayHelper;

class DealController extends Controller
{
    private $dealService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->dealService = new DealService();
    }

    public function actionCreate()
    {
        $answer = $this->dealService->actionDealCreate(); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $user = ArrayHelper::getValue($answer, 'user'); //todo нужен только id.. иначе палится вся информация, вплоть до хеша пароля
        $client = ArrayHelper::getValue($answer, 'client');
        $project = ArrayHelper::getValue($answer, 'project');
        if ($action == 'redirect') { //todo не находит въюху
            return $this->render('view', ['project' => $project, 'client' => $client]);
        } elseif ($action == 'curr') {
            return $this->render('create', [
                'user' => $user,
                'client' => $client,
                'project' => $project,
            ]);
        }
    }
}
