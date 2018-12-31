<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 06.11.2018
 * Time: 23:01
 */

namespace app\service;

use Yii;
use app\models\Servicelist;
use app\models\ServiceSearch;
use app\forms\ServiceListForm;
use app\models\Serviceset;
use app\models\StateCheck;
use yii\helpers\ArrayHelper;
use app\service\ServiceListFormHandler;
use app\service\ServiceListHandler;
use app\service\ReferrerHandler;
use app\service\StartParamsService;


class ServicesetHandler
{
    private $listFormHandler;
    private $listHandler;
    private $referreHandler;
    private $state;

    public function __construct()
    {
        $this->setListHandler(new ServiceListHandler());
        $this->setListFormHandler(new ServiceListFormHandler);
        $this->setReferreHandler(new ReferrerHandler());
        $this->setState(new StateCheck());
    }

    public function setListFormHandler($param)
    {
        $this->listFormHandler = $param;
    }

    public function setListHandler($param)
    {
        $this->listHandler = $param;
    }

    public function setReferreHandler($param)
    {
        $this->referreHandler = $param;
    }

    public function setState($param)
    {
        $this->state = $param;
    }

    public function createServiceset()
    {
        $modelForm = new ServiceListForm(); //todo завести глобальные переменные в классе, делается созданием через конструктор класса. Мои классы собираются именно так
        $action = null;
        $id = null;

        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $referreAddress = Yii::$app->request->getReferrer();
        $gettingId = $this->referreHandler->getReferrerId($referreAddress);

        if ($this->referreHandler->checkLastPage($pathRefer, $pathCurr, $referreAddress)) {

            if (!ArrayHelper::keyExists('id_project', Yii::$app->session)) {
                Yii::$app->session->set('id_project', $gettingId);
            }

            if ($this->listFormHandler->loadServiceList($modelForm)) {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $model = $this->createNewSet();
                    $model->id_project = Yii::$app->session->get('id_project');
                    $model->save();
                    $this->listHandler->saveServiceListArray($this->listFormHandler->getServiceList($model->id_serviceset, $modelForm));
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    $action = 'current';
                }
                $id = Yii::$app->session->get('id_project');
                if(!$action)
                {
                    $action = 'redirect';
                }
            } else {
                $action = 'current';
            }
        } else {
            $action = 'home';
        }

        return ['action' => $action, 'modelForm' => $modelForm, 'id' => $id];
    }

    public function updateServiceset($id)
    {
        $model = $this->findModel($id);

        $modelForm = $this->listFormHandler->getServicelistFormById($id);
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/update';
        $referrerAddress = Yii::$app->request->getReferrer();
        $action = null;
        $prevState = $model->id_state;

        if ($this->referreHandler->checkLastPage($pathRefer, $pathCurr, $referrerAddress)) {
            try {
                if ($model->load(Yii::$app->request->post()) && $model->validate() && $this->listFormHandler->loadServiceList($modelForm)) {
                    $db = \Yii::$app->db;
                    $transaction = $db->beginTransaction();
                    try {
                        if($model->id_state != $prevState) {
                            $model->prev_state = $prevState;
                        }
                        $model->save();
                        $this->listHandler->updateServiceListArray($this->listFormHandler->getServiceList($id, $modelForm), ServiceList::findAll(['id_serviceset' => $id]));
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollback();
                    }
                    $action = 'redirect';
                } else {
                    $action = 'current';
                }

            } catch (StaleObjectException $e) {

                throw new StaleObjectException(Yii::t('app', 'Error data version'));
            }
        }
        else {
            $action = 'home';
        }

        return ['action' => $action, 'modelForm' => $modelForm, 'model' => $model];
    }

    public function deleteServiceset($id)
    {
        $result = false;
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $this->DeleteServicesetById($id);
            $transaction->commit();
            $result = true;
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return $result;
    }

    public function closeServiceset($id)
    {
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->prev_state = $model->id_state;
        $model->id_state = $this->state::Close;
        $model->close_date = date("Y-m-d");
        return $model->save();
    }

    public function cancelServiceset($id)
    {
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->prev_state = $model->id_state;
        $model->id_state = $this->state::Сancellation;
        $model->close_date = date("Y-m-d");
        return $model->save();
    }

    public function changeServicesetState()
    {
        $request = new RequestHandler();
        $message = [
            'success' => '',
            'error' => ''
        ];
        $stateName = $request->getPostRequest('stateNameString');
        $servicesetNum = $request->getPostRequest('setNameString');
        $getStateKey = 'status';
        $getNumKey = 'status-bar';
        $id_state = null;
        $id = null;

        if (($this->referreHandler->checkGetString($stateName, $getStateKey)) && ($this->referreHandler->checkGetString($servicesetNum, $getNumKey))) {
            $id_state = $this->referreHandler->getIdFromStringByKey($stateName, $getStateKey);
            $id = $this->referreHandler->getIdFromStringByKey($servicesetNum, $getNumKey);
        }

        if (($id_state != null) && ($id != null)) {
            $model = $this->findModel($id);
            $model->prev_state = $model->id_state;
            $model->id_state = $id_state;

            if ($id_state < $this->state::Delivery) {
                $model->delivery = null;
            }

            if ($id_state < $this->state::Payment) {
                $model->payment = null;
            }

            $success = [
                'set' => $id,
                'status' => $id_state,
                'delivery' => $this->state::Delivery,
                'payment' => $this->state::Payment,
            ];

            if ($id_state == $this->state::Delivery) {
                $model->delivery = date("Y-m-d");
                if(!$model->payment) {
                    $model->payment = $model->delivery;
                }
                $success['payment_date'] = $model->payment;
                $success['delivery_date'] = $model->delivery;
            }

            if ($id_state == $this->state::Payment) {
                $model->payment = date("Y-m-d");
                $success['payment_date'] = $model->payment;
            }

            ($model->save()) ? ($message['success'] = $success) : ($message['error'] = 'error');
        }

        if ($message['success'] != '') {
            $message['error'] = 'error';
        }

        return $message;
    }

    public function createNewSet()
    {
        $model = new Serviceset();
        $startParam = new StartParamsService();
        $startParam->takeStartParams($model);
        return $model;
    }

    public function DeleteServicesetById($id)
    {
        if (($modelServiceList = ServiceList::findAll(['id_serviceset' => $id])) != null) {
            foreach ($modelServiceList as $el) {
                $el->delete();
            }
        }

        $this->findModel($id)->delete();
    }

    public function getServiceListItems()
    {
        $service = new ServiceSearch();
        return $service->getServiceListItems();
    }

    public function getStateList()
    {
        $state = new StateCheck();
        return $state->getStateList();
    }

    protected function findModel($id)
    {
        if (($model = Serviceset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}