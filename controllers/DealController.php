<?php

namespace app\controllers;

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

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $project = Project::findOne($id);

        if (!isset($user, $project)) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $user->scenario = 'update';
        $project->scenario = 'update';

        if ($user->load(Yii::$app->request->post()) && $project->load(Yii::$app->request->post())) {
            $isValid = $user->validate();
            $isValid = $project->validate() && $isValid;
            if ($isValid) {
                $user->save(false);
                $project->save(false);
                return $this->redirect(['deal/update', 'id' => $id]);
            }
        }

        return $this->render('update', [
            'user' => $user,
            'project' => $project,
        ]);
    }

}
