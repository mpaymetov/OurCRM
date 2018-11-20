<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
use app\models\Serviceset;
use app\models\Servicelist;
use app\models\StateCheck;
use app\models\ServiceListForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use app\service\ServicesetHandler;
use app\service\ServiceListFormHandler;
use app\service\SessionUtility;
use app\service\RequestHandler;

/**
 * ServicesetController implements the CRUD actions for Serviceset model.
 */
class ServicesetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }


    /**
     * Creates a new Serviceset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelForm = new ServiceListForm();
        $listHandler = new ServiceListFormHandler();
        $session = new SessionUtility();
        $request = new RequestHandler();
        $setHandler = new ServicesetHandler();

        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $gettingId = $setHandler->getReferrerId($request->getReferrerAddress());

        if ($setHandler->checkLastPage($pathRefer, $pathCurr, $request->getReferrerAddress())) {

            if (!ArrayHelper::keyExists('id_project', $session->GetSessionArray())) {
                $session->SetSessionElem('id_project', $gettingId);
            }

            if ($listHandler->loadServiceList($modelForm)) {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $setHandler->CreateNewServiceset($session->GetSessionElem('id_project'), $modelForm);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
                $session->RemoveSessionElem('id_project');
                return $this->redirect(['project/view', 'id' => $gettingId]);
            }

            return $this->render('create', [
                'modelForm' => $modelForm,
                'itemsService' => $setHandler->getServiceListItems(),
            ]);

        }

        return $this->redirect(['site/index']);
    }

    /**
     * Updates an existing Serviceset model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $setHandler = new ServicesetHandler();
        print_r($model->tableName());

        $modelForm = $setHandler->getServicelistFormById($id);
        $listHandler = new ServiceListFormHandler();

        $request = new RequestHandler();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/update';

        print_r($model->tableName());
        //if ($this->validateServisesetParam($model)) {
            if ($setHandler->checkLastPage($pathRefer, $pathCurr, $request->getReferrerAddress())) {
                try {

                    if ($model->load(Yii::$app->request->post()) && $model->validate() && $listHandler->loadServiceList($modelForm)) {
                        $db = \Yii::$app->db;
                        $transaction = $db->beginTransaction();
                        try {
                            $model->save();
                            //$data = $listHandler->getServiceList($id, $modelForm);
                            $setHandler->updateServiceListArray($listHandler->getServiceList($id, $modelForm), ServiceList::findAll(['id_serviceset' => $id]));
                            $transaction->commit();
                        } catch (Exception $e) {
                            $transaction->rollback();
                        }
                        return $this->redirect(['project/view', 'id' => $model->id_project]);
                    }

                    return $this->render('update', [
                        'model' => $model,
                        'itemsState' =>$setHandler->getStateList(),
                        'modelForm' => $modelForm,
                        'itemsService' => $setHandler->getServiceListItems(),
                    ]);
                } catch (StaleObjectException $e) {

                    throw new StaleObjectException(Yii::t('app', 'Error data version'));
                }
            }
        //}
        return $this->redirect(['site/index']);
    }

    /**
     * Deletes an existing Serviceset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $setHandler = new ServicesetHandler();
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $setHandler->DeleteServiceset($id);
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }


    public function actionClose($id)
    {
        $stateName = new StateCheck();
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->id_state = $stateName::Delivery;
        $model->save();
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionCancel($id)
    {
        $stateName = new StateCheck();
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->id_state = $stateName::Close;
        $model->save();
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionChangeState()
    {
        $setHandler = new ServicesetHandler();
        $request = new RequestHandler();
        $message = [
            'success' => '',
            'error' => ''
        ];
        $stateName = $request->getPostRequest('stateNameString');
        $servicesetNum = $request->getPostRequest('setNameString');
        $state = new StateCheck();
        $getStateKey = 'status';
        $getNumKey = 'status-bar';
        $id_state = null;
        $id = null;

        if (($setHandler->checkGetString($stateName, $getStateKey)) && ($setHandler->checkGetString($servicesetNum, $getNumKey))) {
            $id_state = $setHandler->getIdFromStringByKey($stateName, $getStateKey);
            $id = $setHandler->getIdFromStringByKey($servicesetNum, $getNumKey);
        }

        //Нужно добавить проверку номера serviceset

        if (($id_state != null) && ($id != null)) {
            $model = $this->findModel($id);
           // if ($this->validateServisesetParam($model)) { //добавил сюда
                $model->id_state = $id_state;

                if($id_state < $state::Delivery) {
                    $model->delivery = null;
                }

                if($id_state < $state::Payment) {
                    $model->payment = null;
                }

                $success = [
                    'set' => $id,
                    'status' => $id_state,
                    'delivery' => $state::Delivery,
                    'payment' => $state::Payment,
                ];

                if($id_state == $state::Delivery) {
                    $model->delivery = date("Y-m-d");
                    $success['delivery_date'] = $model->delivery;
                }

                if($id_state == $state::Payment) {
                    $model->payment = date("Y-m-d");
                    $success['payment_date'] = $model->payment;
                }

                ($model->save()) ? ($message['success'] = $success) : ($message['error'] = 'error');
            //}

            if (!$message['success']) {
                $message['error'] = 'error';
            }

            echo json_encode($message);
        }
    }


    /**
     * Finds the Serviceset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Serviceset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Serviceset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
