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
use app\db_modules\servisetDbQuery;
use app\service\ServiceListFormHandler;


class ServicesetHandler
{

    public function createServiceset()
    {
        $modelForm = new ServiceListForm(); //todo завести глобальные переменные в классе, делается созданием через конструктор класса. Мои классы собираются именно так
        $listHandler = new ServiceListFormHandler();
        $session = new SessionUtility();
        $request = new RequestHandler();
        $action = null;
        $id = null;

        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $gettingId = $this->getReferrerId($request->getReferrerAddress());

        if ($this->checkLastPage($pathRefer, $pathCurr, $request->getReferrerAddress())) {

            if (!ArrayHelper::keyExists('id_project', $session->GetSessionArray())) {
                $session->SetSessionElem('id_project', $gettingId);
            }

            if ($listHandler->loadServiceList($modelForm)) {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $this->CreateNewServiceset($session->GetSessionElem('id_project'), $modelForm);
                    /*$model = $this->CreateNewSet($session->GetSessionElem('id_project'));
                    $model->save();
                    $this->CreateNewLists($model->id_serviceset, $modelForm);*/
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
                $id = $session->GetSessionElem('id_project');
                $session->RemoveSessionElem('id_project');
                $action = 'redirect';
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
        print_r($model->tableName());

        $modelForm = $this->getServicelistFormById($id);
        $listHandler = new ServiceListFormHandler();

        $request = new RequestHandler();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/update';

        print_r($model->tableName());
        $action = null;

        //if ($this->validateServisesetParam($model)) {
        if ($this->checkLastPage($pathRefer, $pathCurr, $request->getReferrerAddress())) {
            try {

                if ($model->load(Yii::$app->request->post()) && $model->validate() && $listHandler->loadServiceList($modelForm)) {
                    $db = \Yii::$app->db;
                    $transaction = $db->beginTransaction();;
                    try {
                        $model->save();
                        //$data = $listHandler->getServiceList($id, $modelForm);
                        $this->updateServiceListArray($listHandler->getServiceList($id, $modelForm), ServiceList::findAll(['id_serviceset' => $id]));
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
        } //}
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
        $stateName = new StateCheck();
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->id_state = $stateName::Close;
        $model->close_date = date("Y-m-d");
        return $model->save();
    }

    public function cancelServiceset($id)
    {
        $stateName = new StateCheck();
        $model = $this->findModel($id);
        $model->is_open = 0;
        $model->id_state = $stateName::Сancellation;
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
        $state = new StateCheck();
        $getStateKey = 'status';
        $getNumKey = 'status-bar';
        $id_state = null;
        $id = null;

        if (($this->checkGetString($stateName, $getStateKey)) && ($this->checkGetString($servicesetNum, $getNumKey))) {
            $id_state = $this->getIdFromStringByKey($stateName, $getStateKey);
            $id = $this->getIdFromStringByKey($servicesetNum, $getNumKey);
        }

        //Нужно добавить проверку номера serviceset

        if (($id_state != null) && ($id != null)) {
            $model = $this->findModel($id);
            // if ($this->validateServisesetParam($model)) { //добавил сюда
            $model->id_state = $id_state;

            if ($id_state < $state::Delivery) {
                $model->delivery = null;
            }

            if ($id_state < $state::Payment) {
                $model->payment = null;
            }

            $success = [
                'set' => $id,
                'status' => $id_state,
                'delivery' => $state::Delivery,
                'payment' => $state::Payment,
            ];

            if ($id_state == $state::Delivery) {
                $model->delivery = date("Y-m-d");
                $success['delivery_date'] = $model->delivery;
            }

            if ($id_state == $state::Payment) {
                $model->payment = date("Y-m-d");
                $success['payment_date'] = $model->payment;
            }

            ($model->save()) ? ($message['success'] = $success) : ($message['error'] = 'error');
            //}
        }

        if ($message['success'] != '') {
            $message['error'] = 'error';
        }

        return $message;
    }


    public function CreateNewSet($idProject)
    {
        $model = new Serviceset();
        $stateName = new StateCheck();
        $model->id_project = $idProject;
        $model->id_state = $stateName::MakeContact;
        $model->creation_date = date("Y-m-d");
        return $model;
    }

    public function CreateNewLists($id, $modelForm)
    {
        $listHandler = new ServiceListFormHandler();
        $this->saveServiceListArray($listHandler->getServiceList($id, $modelForm));
    }

    public function CreateNewServiceset($idProject, $modelForm)
    {
        $model = $this->CreateNewSet($idProject);
        $model->save();
        $this->CreateNewLists($model->id_serviceset, $modelForm);
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


    public function findServiceList($id)
    {
        $serviceListInfo = new servisetDbQuery();
        $setInfo = $serviceListInfo->getServiceSetInfo($id);
        $arr = [];
        for ($i = 0; $i < count($setInfo); $i++) {
            $arr[$i] = ['Service' => $setInfo[$i]['id']];
        }
        return $arr;
    }

    public function getServicelistFormById($id)
    {
        $modelForm = new ServiceListForm();
        $modelForm->serviceList = $this->findServiceList($id);
        return $modelForm;
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


    public function checkLastPage($pathRefer, $pathCurr, $address) //todo перенести в валидатор
    {
        $gettingId = $this->getReferrerId($address);

        return ((($this->checkPage($address, $pathRefer)) && ($gettingId != NULL)) || ($this->checkPage($address, $pathCurr)));
    }

    public function updateServiceListArray($arrData, $arrModel)
    {

        $num = min(count($arrData), count($arrModel));

        if ($num != 0) {
            for ($i = 0; $i < $num; $i++) {
                $arrModel[$i]->saveServiceList($arrData[$i]);
            }
        }

        if (count($arrData) > count($arrModel)) {
            for ($i = $num; $i < count($arrData); $i++) {
                $model = new Servicelist();
                $model->saveServiceList($arrData[$i]);
            }
        }

        for ($i = $num; $i < count($arrModel); $i++) {
            $arrModel[$i]->delete();
        }
    }

    public function saveServiceListArray($arr)
    {
        foreach ($arr as $item) {
            $model = new Servicelist();
            $model->saveServiceList($item);
        }
    }

    public function saveNewServiceSet($project_id)
    {
        $model = new Serviceset();
        $model->id_project = $project_id;
        $model->id_state = 1;
        if (!($model->save())) {
            return NULL;
        }
        return $model->id_serviceset;
    }

    public function getReferrerId($str) //todo перенести в referer handler
    {
        $result = NULL;
        parse_str($str, $el);
        if (ArrayHelper::keyExists('id', $el)) {
            $result = (integer)$el['id'];
        }
        return $result;
    }

    public function checkPage($str, $path)
    {
        $query = parse_url($str, PHP_URL_QUERY);
        parse_str($query, $el);
        if (ArrayHelper::keyExists('r', $el)) {
            return ($el['r'] === $path);
        }
        return false;
    }

    public function checkGetString($str, $key)
    {
        //проверить есть ли в $str выражение вида ' $key.-. цифра '
        $reg = '/' . $key . '-[0-9]{1,}/';
        return preg_match($reg, $str, $result);
    }

    public function getIdFromStringByKey($str, $key)
    {
        //найти в $str из выражение вида ' $key.-. цифра ' цифру
        $arr = explode(' ', $str);
        $reg = '/' . $key . '-[0-9]{1,}/';
        $id = null;
        $counter = 0;
        foreach ($arr as $el) {
            if (preg_match($reg, $el, $findEl)) {
                preg_match('/[0-9]{1,}/', $findEl[0], $result);
                $id = $result[0];
                $counter++;
            }
        }

        if ($counter != 1) {
            $id = null;
        }

        return $id;
    }

    protected function findModel($id)
    {
        if (($model = Serviceset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}