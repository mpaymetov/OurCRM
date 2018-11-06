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
    public function actionCreate()
    {
        $answer = DealService::actionDealCreate(); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        if ($action == 'redirect') {
            return $this->redirect(['create']);
        } elseif ($action == 'curr') {
            return $this->render('update', [
                'model' => $model,]);
        }
        /* $user = User::findOne(Yii::$app->user->identity->id_user);
         $project = new Project();
         $client = new Client();
         if (!isset($user, $project, $client)) {
             throw new NotFoundHttpException("Something get wrong");
         }
         $this->takeStartParams($project);
         $this->takeStartParams($client);
         if ($this->dataControl($project) && $this->dataControl($client)) {
             if ($project->load(Yii::$app->request->post()) && $client->load(Yii::$app->request->post())) {
                 {
                     $client->save(false);
                     $project->id_client = $client->id_client;
                     $project->save(false);
                     return $this->redirect(['deal/create']);
                 }
             }
         }
         return $this->render('create', [
             'user' => $user,
             'project' => $project,
             'client' => $client,
         ]);*/
    }

}
