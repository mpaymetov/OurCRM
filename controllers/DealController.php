<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\Client;
use app\models\Project;
use app\service\DealService;
use yii\helpers\ArrayHelper;

class DealController extends Controller
{
    private $dealService;

    public function init()
    {
        $this->getService();
    }

    /**
     *
     */
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
            var_dump($project);
          //return $this->redirect(['project/view_deal', 'id' => $project->id_project]);
        } elseif ($action == 'curr') {
            return $this->render('create', [
                'user' => $user,
                'client' => $client,
                'project' => $project,
            ]);
        }
    }
}
