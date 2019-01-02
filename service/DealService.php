<?php

namespace app\service;

use Yii;
use app\models\User;
use app\models\Project;
use app\models\Client;
use app\models\Person;
use yii\web\NotFoundHttpException;
use app\service\ServiceListFormHandler;
use app\service\ServiceListHandler;
use app\service\ServicesetHandler;
use app\forms\ServiceListForm;

class DealService
{
    private $startParams;
    private $dataControl;
    private $userService;
    private $setHandler;
    private $listHandler;
    private $listFormHandler;

    public function __construct()
    {
        $this->setStartParams(new StartParamsService()) ;
        $this->setDataControl(new DataValidateService());
        $this->setUserService(new UserService());
        $this->servicesetHandlerInit();
    }

    public function servicesetHandlerInit()
    {
        $this->setHandler = new ServicesetHandler();
        $this->listHandler = new ServiceListHandler();
        $this->listFormHandler = new ServiceListFormHandler();
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
        $modelForm = new ServiceListForm();
        if (!isset($user, $project, $client, $person)) {
            throw new NotFoundHttpException("Something get wrong");
        }
        $this->startParams->takeStartParams($project);
        $this->startParams->takeStartParams($client);
        $this->startParams->takeStartParams($person);

        if ($project->load(Yii::$app->request->post())
                && $client->load(Yii::$app->request->post())
                && $person->load(Yii::$app->request->post())
                && $modelForm->load(Yii::$app->request->post())
                && $this->dataControl->dataControl($client)) {

            $client->save(false);
            $project->id_client = $client->id_client;

            if ($this->dataControl->dataControl($project)) {
                $project->save(false);
                $person->id_client = $client->id_client;
                $person->main = 1;
                $person->save();
                $set = $this->setHandler->createNewSet();
                $set->id_project = $project->id_project;
                $set->save();
                $this->listHandler->saveServiceListArray($this->listFormHandler->getServiceList($set->id_serviceset, $modelForm));
                $user = $this->userService->findLoginById($user->id_user);
                return [
                    'user' => $user,
                    'project' => $project,
                    'client' => $client,
                    'person' => $person,
                    'modelForm' => $modelForm,
                    'itemsService' => $this->setHandler->getServiceListItems(),
                    'action' => 'redirect',
                ];

            }
        }
        return [
            'user' => $user,
            'project' => $project,
            'client' => $client,
            'person' => $person,
            'modelForm' => $modelForm,
            'itemsService' => $this->setHandler->getServiceListItems(),
            'action' => 'curr',
        ];
    }


}