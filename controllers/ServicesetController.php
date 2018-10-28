<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use app\models\Serviceset;
use app\models\ServicesetSearch;
use app\models\Servicelist;
use app\models\ServicelistSearch;
use app\models\Service;
use app\models\Project;
use app\models\StateCheck;
use app\models\ServiceSearch;
use app\models\ServiceListForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\web\Request;
use yii\web\Session;

/**
 * ServicesetController implements the CRUD actions for Serviceset model.
 */
class ServicesetController extends SecurityController
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
     * Lists all Serviceset models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new ServicesetSearch();
        $state = new StateCheck();
        $list = $state->getStateList();
        $dataProvider = [];
        $item = [];
        for($i = 0; $i < count($list) - 1; $i++)
        {
            $item['state'] = $list[$i];
            $item['info'] = new ArrayDataProvider([
                'allModels' => $searchModel->getServiceSetInfoByStateAndUser($i, Yii::$app->user->identity->id_user)
                ]);
            $dataProvider[] = $item;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Serviceset model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
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
    }

    /**
     * Creates a new Serviceset model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $stateName = new StateCheck();
        $itemsService = $service->getServiceListItems();

        $session = Yii::$app->session;
        $address = Yii::$app->request->getReferrer();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $gettingId = $this->getReferrerId($address);

        if ((($this->checkPage($address, $pathRefer)) && ($this->getReferrerId($address) != NULL)) || ($this->checkPage($address, $pathCurr))) {
            if (!ArrayHelper::keyExists('id_project', $session)) {
                $session->set('id_project', $gettingId);
            }

            if ($modelForm->loadServiceList()) {
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $model = new Serviceset();
                    $model->id_project = $session->get('id_project');
                    $model->id_state = $stateName::MakeContact;
                    $model->save();
                    $id = $model->id_serviceset;
                    $data = $modelForm->getServiceList($id);
                    $this->saveServiceListArray($data);
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
        print_r($model->tableName());
        $state = new StateCheck();
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();
        $itemsState = $state->getStateList();
        $modelForm->serviceList = $this->findServiceList($id);
        $modelServiceList = ServiceList::findAll(['id_serviceset' => $id]);

        $session = Yii::$app->session;
        $address = Yii::$app->request->getReferrer();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/update';
        $gettingId = $this->getReferrerId($address);

        print_r($model->tableName());
        if ($this->validateServisesetParam($model)) {
            if ((($this->checkPage($address, $pathRefer)) && ($this->getReferrerId($address) != NULL)) || ($this->checkPage($address, $pathCurr))) {
                try {
                    $data = 0;

                    if ($model->load(Yii::$app->request->post()) && $model->validate() && $modelForm->loadServiceList()) {
                        $db = \Yii::$app->db;
                        $transaction = $db->beginTransaction();
                        try {
                            $model->save();
                            $data = $modelForm->getServiceList($id);
                            $this->updateServiceListArray($data, $modelServiceList);
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
        }
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

        if (($this->checkGetString($stateName, $getStateKey)) && ($this->checkGetString($servicesetNum, $getNumKey))) {
            $id_state = $this->getIdFromStringByKey($stateName, $getStateKey);
            $id = $this->getIdFromStringByKey($servicesetNum, $getNumKey);
        }

        //Нужно добавить проверку номера serviceset

        if (($id_state != null) && ($id != null)) {
            $model = $this->findModel($id);
            if ($this->validateServisesetParam($model)) { //добавил сюда
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
            }

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

    protected
    function findServiceList($id)
    {
        $serviceListInfo = new ServicelistSearch();
        $setInfo = $serviceListInfo->getServiceSetInfo($id);
        $arr = [];
        for ($i = 0; $i < count($setInfo); $i++) {
            $arr[$i] = ['Service' => $setInfo[$i]['id']];
        }
        return $arr;
    }

    protected
    function updateServiceListArray($arrData, $arrModel)
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

    protected
    function saveServiceListArray($arr)
    {
        foreach ($arr as $item) {
            $model = new Servicelist();
            $model->saveServiceList($item);
        }
    }

    protected
    function saveNewServiceSet($project_id)
    {
        $model = new Serviceset();
        $model->id_project = $project_id;
        $model->id_state = 1;
        if (!($model->save())) {
            return NULL;
        }
        return $model->id_serviceset;
    }

    protected
    function getReferrerId($str)
    {
        $result = NULL;
        parse_str($str, $el);
        if (ArrayHelper::keyExists('id', $el)) {
            $result = (integer)$el['id'];
        }
        return $result;
    }

    protected
    function checkPage($str, $path)
    {
        $query = parse_url($str, PHP_URL_QUERY);
        parse_str($query, $el);
        if (ArrayHelper::keyExists('r', $el)) {
            return ($el['r'] === $path);
        }
        return false;
    }

    protected
    function checkGetString($str, $key)
    {
        //проверить есть ли в $str выражение вида ' $key.-. цифра '
        $reg = '/' . $key . '-[0-9]{1,}/';
        return preg_match($reg, $str, $result);
    }

    protected
    function getIdFromStringByKey($str, $key)
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
}
