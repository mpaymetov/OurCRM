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
use app\service\ServicesetService;
use app\service\RequestHandler;

/**
 * ServicesetController implements the CRUD actions for Serviceset model.
 */
class ServicesetController extends Controller
{
    private $setHandler;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->setHandler = new ServicesetHandler();
    }


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
        $answer = $this->setHandler->createServiceset();
        $action = ArrayHelper::getValue($answer, 'action');
        $modelForm = ArrayHelper::getValue($answer, 'modelForm');
        $id = ArrayHelper::getValue($answer, 'id');

        if ($action == 'redirect') {
            return $this->redirect(['project/view', 'id' => $id]);
        } elseif ($action == 'current') {
            return $this->render('create', [
                'modelForm' => $modelForm,
                'itemsService' => $this->setHandler->getServiceListItems(),
            ]);
        } elseif ($action == 'home') {
            return $this->redirect(['site/index']);
        }
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

        $answer = $this->setHandler->updateServiceset($id);
        $action = ArrayHelper::getValue($answer, 'action');
        $modelForm = ArrayHelper::getValue($answer, 'modelForm');
        $model = ArrayHelper::getValue($answer, 'model');

        if ($action == 'redirect') {
            return $this->redirect(['project/view', 'id' => $model->id_project]);
        } elseif ($action == 'current') {
            return $this->render('update', [
                'model' => $model,
                'itemsState' =>$this->setHandler->getStateList(),
                'modelForm' => $modelForm,
                'itemsService' => $this->setHandler->getServiceListItems(),
            ]);
        } elseif ($action == 'home') {
            return $this->redirect(['site/index']);
        }
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
       if($this->setHandler->deleteServiceset($id)) {
           return $this->redirect(Yii::$app->request->getReferrer());
       }
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
