<?php

namespace app\service;

use app\controllers\ProjectController;
use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\ServicesetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\models\EventSearch;
use yii\db\StaleObjectException;
use app\db_modules\servisetDbQuery;

class ProjectService
{   // php не дает сразу инициализировать переменные объектами, поэтому нужны фукции get создающие новые объекты нужных классов
    // но в данном конкретном случае, он их не создает
    private $startParams;
    private $dataControl;
// аписать коструктор для этого класса __construct
//попробовать подключать класс конфигурации и подавать туда конкретный data control
    public function __construct()
    {
        $this->setStartParams(new StartParamsService());
        $this->setDataControl(new DataValidateService());
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
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public function getViewInfoProject($id)
    {
        $searchModel = new ServicesetSearch();
        $dataProvider = $searchModel->searchProjectById($id);
        $servicesetData = new servisetDbQuery();
        $servicesetInfo = $servicesetData->getServiceSetInfoByProjectId($id);
        $serviceListDataProvider = [];
        for ($i = 0; $i < count($servicesetInfo); $i++) {
            $info = $servicesetInfo[$i];
            $serviceListDataProvider[$i] = array(
                'ServiceSetInfo' => new ArrayDataProvider([
                    'allModels' => array(
                        0 => $info),
                ]),
                'ServiceListInfo' => new ArrayDataProvider([
                    'allModels' => $servicesetData->getServiceSetInfo($info['id']),
                ]),
            );
        }

        $searchEventModel = new EventSearch();
        $eventDataProvider = $searchEventModel->searchEventId($id, Yii::$app->user->identity->id_user, 2);
        $search = new ProjectSearch();
        $model = $search->findModel($id);
        if ($this->dataControl->checkElemAvailable($model)) {
            return [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'eventDataProvider' => $eventDataProvider,
                'serviceListDataProvider' => $serviceListDataProvider,
            ];
        }
    }

    public function setProject()
    {
        $model = new Project();
        $this->startParams->takeStartParams($model);
        if ($model->load(Yii::$app->request->post()) && $this->dataControl->dataControl($model) && $model->save()) {
            return ['model' => $model, 'action' => 'redirect'];
        }
        return ['model' => $model, 'action' => 'curr'];
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
