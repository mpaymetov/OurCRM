<?php

namespace app\service;

use Yii;
use app\models\User;
use app\models\Project;
use app\models\Client;
use app\models\Person;
use yii\web\NotFoundHttpException;

class DealService
{
    private $startParams;
    private $dataControl;
    private $userService;

    public function __construct()
    {
        $this->setStartParams(new StartParamsService()) ;
        $this->setDataControl(new DataValidateService());
        $this->setUserService(new UserService());
    }

    public function setDataControl($dataControlService)
    {
        $this->dataControl = $dataControlService;
    }

    public function setStartParams($startParams)
    {
        $this->startParams = $startParams;
    }

    Public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function actionDealCreate()
    {
        $user = User::findOne(Yii::$app->user->identity->id_user);//todo использовать метод из сервиса
        $project = new Project();
        $client = new Client();
        $person = new Person();
        if (!isset($user, $project, $client, $person)) {
            throw new NotFoundHttpException("Something get wrong");
        }
        $this->startParams->takeStartParams($project);
        $this->startParams->takeStartParams($client);
        $this->startParams->takeStartParams($person);
        if ($this->dataControl->dataControl($project) && $this->dataControl->dataControl($client)) {
            if ($project->load(Yii::$app->request->post())
                && $client->load(Yii::$app->request->post())
                && $person->load(Yii::$app->request->post())) {
                {
                    $client->save(false);
                    $project->id_client = $client->id_client;
                    $project->save(false);
                    $person->id_client = $client->id_client;
                    $person->main = 1;
                    $person->save();
                    $user = $this->userService->findLoginById($user->id_user);
                    return [
                        'user' => $user,
                        'project' => $project,
                        'client' => $client,
                        'person' => $person,
                        'action' => 'redirect',
                    ];
                }
            }
        }
        return [
            'user' => $user,
            'project' => $project,
            'client' => $client,
            'person' => $person,
            'action' => 'curr',
        ];
    }


}