<?php

namespace app\controllers;

use app\service\DataValidateService;
use Yii;
use app\models\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use app\service\ClientService;
use app\forms\ClientMoveForm;
use app\service\UserService;
use yii\helpers\ArrayHelper;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * {@inheritdoc}
     */
    private $clientService;
    private $userService;

    /**
     *
     */
    public function init()
    {
        $this->getClientService(new ClientService());
        $this->getUserService();
    }

    public function getClientService($service)
    {
        $this->clientService = $service;
    }

    public function getUserService()
    {
        $this->userService = new UserService();
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

        return $this->render('index', $this->clientService->getAllClients()
        );

    }

    /**
     * Displays a single Client model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', $this->clientService->getClientViewData($id)
        );

    }


    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $answer = $this->clientService->setClient(); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        $modelPerson = ArrayHelper::getValue($answer, 'modelPerson');
        if ($action == 'redirect') {
            return $this->redirect(['view', 'id' => $model->id_client]);
        } elseif ($action == 'curr') {
            var_dump($action);
            return $this->render('create', [
                'model' => $model,
                'modelPerson' => $modelPerson]);
        }
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
        $managerList = $this->userService->GetManagerList(Yii::$app->user->identity->id_department);
        $clientList = $this->clientService->GetClientList(Yii::$app->user->identity->id_user);

        $clientMove = new ClientMoveForm();
        $clientMove->idClient = $id;

        if($clientMove->load(Yii::$app->request->post())) { //TODO добавить проверку на загруженные idClient и idManager
            $model = $this->findModel($id);
            $model->id_user = $clientMove->idManager;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('move', [
            'managerList' => $managerList,
            'clientList' => $clientList,
            'clientMove' => $clientMove
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