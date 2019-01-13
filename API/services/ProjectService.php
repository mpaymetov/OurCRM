<?php

namespace app\api\services;

use app\controllers\ProjectController;
use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\StateCheck;
use app\models\Serviceset;
use app\models\Servicelist;
use app\forms\ServiceListForm;
use app\models\ServicesetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\models\EventSearch;
use yii\db\StaleObjectException;
use app\db_modules\servisetDbQuery;
use app\service\ServiceListFormHandler;
use app\service\ServiceListHandler;
use app\service\ClientService;
use app\service\ServicesetHandler;
use app\service\StartParamsService;
use app\service\DataValidateService;

class ProjectService
{
    private $startParams;
    private $dataControl;
    private $clientService;
    private $setHandler;
    private $listHandler;
    private $listFormHandler;

    public function __construct()
    {
        $this->setStartParams(new StartParamsService());
        $this->setDataControl(new DataValidateService());
    }

    public function servicesetHandlerInit()
    {
        $this->clientService = new ClientService();
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

    public function getAllProjects()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $dataProvider;
    }

    public function getViewInfoProject($id)
    {
        $servicesetData = new servisetDbQuery();
        $servicesetInfo = $servicesetData->getServiceSetInfoByProjectId($id);
        $serviceListDataProvider = [];
        for ($i = 0; $i < count($servicesetInfo); $i++) {
            /*$info = $servicesetInfo[$i];
            $serviceListDataProvider[$i] = array(
                'ServiceSetInfo' => new ArrayDataProvider([
                    'allModels' => array(
                        0 => $info),
                ]),
                'ServiceListInfo' => new ArrayDataProvider([
                    'allModels' => $servicesetData->getServiceSetInfo($info['id']),
                ]),
            );*/
            $serviceListDataProvider[$i] = array(
                'servicesetInfo' => $servicesetInfo[$i],
                'servicelistInfo' => $servicesetData->getServiceSetInfo($servicesetInfo[$i]['id'])
            );

        }

        $searchEventModel = new EventSearch();
        $eventDataProvider = $searchEventModel->searchEventId($id, Yii::$app->user->identity->id_user, 2);

        $state = new StateCheck();
        $list = $state->getStateList();

        $search = new ProjectSearch();
        $model = $search->findModel($id);
        if ($this->dataControl->checkElemAvailable($model)) {
            return [
                'project' => $model,
                'event' => $eventDataProvider,
                'serviceset' => $serviceListDataProvider,
                'state' => $list
            ];
        }
    }

    public function setProject()
    {
        $model = new Project();
        $modelForm = new ServiceListForm();
        $this->servicesetHandlerInit();
        $clientList = null;

        $this->startParams->takeStartParams($model);
        if($model->id_client == null) {
            $clientList = $this->clientService->GetClientList(Yii::$app->user->identity->id_user);
        }

        if ($model->load(Yii::$app->request->post()) && $this->dataControl->dataControl($model) && $modelForm->load(Yii::$app->request->post())) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $model->save();

                $set = $this->setHandler->createNewSet();
                $set->id_project = $model->id_project;
                $set->save();

                $this->listHandler->saveServiceListArray($this->listFormHandler->getServiceList($set->id_serviceset, $modelForm));

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                return ['model' => $model,
                    'modelForm' => $modelForm,
                    'itemsService' => $this->setHandler->getServiceListItems(),
                    'clientList' => $clientList, 'action' => 'curr'];
            }

            return ['model' => $model,
                'modelForm' => $modelForm,
                'itemsService' => $this->setHandler->getServiceListItems(),
                'clientList' => $clientList, 'action' => 'redirect'];
        }
        return ['model' => $model,
            'modelForm' => $modelForm,
            'itemsService' => $this->setHandler->getServiceListItems(),
            'clientList' => $clientList, 'action' => 'curr'];
    }

    public function setUpdateProject($id)
    {
        $session = Yii::$app->session;
        $session->set('id_project', $id);
        $search = new ProjectSearch();
        $model = $search->findModel($id);
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['model' => $model, 'action' => 'redirect'];
            };
            return [
                'model' => $model, 'action' => 'curr'
            ];

        } catch
        (StaleObjectException $e) {
            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }

    public function actionProjectDeleteRequest($id)
    {
        $search = new ProjectSearch();
        $model = $search->findModel($id);
        if ($this->dataControl->checkElemAvailable($model)) {
            $model->delete();
            return true;
        }
    }
}
