<?php

namespace app\controllers;


use Yii;
use app\models\Serviceset;
use app\models\Servicelist;
use app\models\StateCheck;
use app\models\ServiceSearch;
use app\models\ServiceListForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use app\service\ServicesetHandler;
use app\service\ServiceListFormHandler;

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
     * Displays a single Serviceset model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   /* public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();
        if ($modelForm->loadServiceList()) {
            $data = $modelForm->getServiceList($id);
            $this->saveServiceListArray($data);
            return $this->redirect(['project/view', 'id' => $this->findModel($id)->id_project]);
        }

        return $this->render('view', [
            'model' => $model,
            'modelForm' => $modelForm,
            'itemsService' => $itemsService,
        ]);
    }*/

    /**
     * Creates a new Serviceset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelForm = new ServiceListForm();
        $listHandler = new ServiceListFormHandler();

        $stateName = new StateCheck();

        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();

        $session = Yii::$app->session;
        $address = Yii::$app->request->getReferrer();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $setHandler = new ServicesetHandler();
        $gettingId = $setHandler->getReferrerId($address);

        if ((($setHandler->checkPage($address, $pathRefer)) && ($setHandler->getReferrerId($address) != NULL)) || ($setHandler->checkPage($address, $pathCurr))) {
            if (!ArrayHelper::keyExists('id_project', $session)) {
                $session->set('id_project', $gettingId);
            }

            if ($listHandler->loadServiceList($modelForm)) {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $model = new Serviceset();
                    $model->id_project = $session->get('id_project');
                    $model->id_state = $stateName::MakeContact;
                    $model->save();
                    $id = $model->id_serviceset;
                    $data = $listHandler->getServiceList($id, $modelForm);
                    $setHandler->saveServiceListArray($data);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
                $session->remove('id_project');
                return $this->redirect(['project/view', 'id' => $model->id_project]);
            }

            return $this->render('create', [
                'modelForm' => $modelForm,
                'itemsService' => $itemsService,
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

        $modelForm = new ServiceListForm();
        $listHandler = new ServiceListFormHandler();

        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();

        $state = new StateCheck();
        $itemsState = $state->getStateList();

        $modelForm->serviceList = $setHandler->findServiceList($id);
        $modelServiceList = ServiceList::findAll(['id_serviceset' => $id]);

        $session = Yii::$app->session;
        $address = Yii::$app->request->getReferrer();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/update';


        $gettingId = $setHandler->getReferrerId($address);

        print_r($model->tableName());
        //if ($this->validateServisesetParam($model)) {
            if ((($setHandler->checkPage($address, $pathRefer)) && ($setHandler->getReferrerId($address) != NULL)) || ($setHandler->checkPage($address, $pathCurr))) {
                try {
                    $data = 0;

                    if ($model->load(Yii::$app->request->post()) && $model->validate() && $listHandler->loadServiceList($modelForm)) {
                        $db = \Yii::$app->db;
                        $transaction = $db->beginTransaction();
                        try {
                            $model->save();
                            $data = $listHandler->getServiceList($id, $modelForm);
                            $setHandler->updateServiceListArray($data, $modelServiceList);
                            $transaction->commit();
                        } catch (Exception $e) {
                            $transaction->rollback();
                        }
                        return $this->redirect(['project/view', 'id' => $model->id_project]);
                    }

                    return $this->render('update', [
                        'model' => $model,
                        'itemsState' => $itemsState,
                        'modelForm' => $modelForm,
                        'itemsService' => $itemsService,
                        'modelServiceList' => $modelServiceList,
                        'data' => $data,
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
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            if (($modelServiceList = ServiceList::findAll(['id_serviceset' => $id])) != null) {
                foreach ($modelServiceList as $el) {
                    $el->delete();
                }
            }
            $this->findModel($id)->delete();
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
        $request = Yii::$app->request;
        $message = [
            'success' => '',
            'error' => ''
        ];
        $stateName = $request->post('stateNameString');
        $servicesetNum = $request->post('setNameString');
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
