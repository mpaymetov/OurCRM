<?php

namespace app\controllers;

use app\service\DataValidateService;
use app\service\StartParamsService;
use Yii;
use app\models\Client;
use app\models\ClientSearch;
use app\models\Person;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ProjectSearch;
use app\models\EventSearch;
use yii\db\StaleObjectException;
use app\service\ClientService;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * {@inheritdoc}
     */
    private $service;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->service = new ClientService();
    }



    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $session = Yii::$app->session;
        $session->set('id_client', $id);
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->searchClientProject($id);
        $searchEventModel = new EventSearch();
        $eventDataProvider = $searchEventModel->searchEventId($id, Yii::$app->user->identity->id_user, 1);
        $searchClientEventModel = new EventSearch();
        $clientEventDataProvider = $searchClientEventModel->searchClientEventId($id, Yii::$app->user->identity->id_user, 1);
        //$arr = $this->service->GetManagerList(Yii::$app->user->identity->id_department);
        $person = $this->service->GetMainPersonInfo($id);
        return $this->render('view', [
            'model' => $this->findModel($id, Yii::$app->user->identity->id_user),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchEventModel' => $searchEventModel,
            'eventDataProvider' => $eventDataProvider,
            'clientEventDataProvider' => $clientEventDataProvider,
            'person' => $person,
            //'arr' => $arr
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();
        $modelPerson = new Person();
        $startParams = new StartParamsService();
        $dataControl = new DataValidateService();
        $startParams->takeStartParams($model);
        $startParams->takeStartParams($modelPerson);
        if ($dataControl->dataControl($model)) {
            if ($model->load(Yii::$app->request->post()) && $modelPerson->load(Yii::$app->request->post()) && $this->service->SaveNewClientAndPerson($model, $modelPerson)) {
                return $this->redirect(['view', 'id' => $model->id_client]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelPerson' => $modelPerson
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $session = Yii::$app->session;
        $session->set('id_client', $id);
        $dataControl = new DataValidateService();
        $model = $this->findModel($id);
        try {
            if ($dataControl->compareUserId($model)) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id_client]);
                }
                return $this->render('update', [
                    'model' => $model,]);
            }
            return $this->render('update', [
                'model' => $model,]);
        } catch (StaleObjectException $e) {
            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }


    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionMove($id)
    {
        $list = $this->service->GetManagerList(Yii::$app->user->identity->id_department);
        return $this->render('move', [
            'list' => $list
        ]);

    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            if ($model->id_user == Yii::$app->user->identity->id_user) {
                return $model;
            }
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}