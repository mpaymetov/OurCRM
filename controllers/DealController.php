<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\Client;
use app\models\Project;

class DealController extends SecurityController
{
    public function actionCreate()
    {
        $user = User::findOne(Yii::$app->user->identity->id_user);
        $project = new Project();
        $client = new Client();
        if (!isset($user, $project, $client)) {
            throw new NotFoundHttpException("The user was not found.");
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
        ]);
    }
}