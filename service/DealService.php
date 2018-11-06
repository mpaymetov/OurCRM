<?php

namespace app\service;

use Yii;
use app\models\User;
use app\models\Project;
use app\models\Client;

class DealService
{
    public static function actionDealCreate()
    {
        $user = User::findOne(Yii::$app->user->identity->id_user);
        $project = new Project();
        $client = new Client();
        if (!isset($user, $project, $client)) {
            throw new NotFoundHttpException("Something get wrong");
        }
        $startParams = new StartParamsService();
        $startParams->takeStartParams($project);
        $startParams->takeStartParams($client);
        $dataControl = new DataControlService();
        if ($dataControl->dataControl($project) && $dataControl->dataControl($client)) {
            if ($project->load(Yii::$app->request->post()) && $client->load(Yii::$app->request->post())) {
                {
                    $client->save(false);
                    $project->id_client = $client->id_client;
                    $project->save(false);
                    return [
                        'user' => $user,
                        'project' => $project,
                        'client' => $client,
                        'action' => 'redirect',
                    ];
                }
            }
        }
        return [
            'user' => $user,
            'project' => $project,
            'client' => $client,
            'action' => 'curr',
        ];
    }


}