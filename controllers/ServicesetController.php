<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use app\models\Serviceset;
use app\models\ServicesetSearch;
use app\models\Servicelist;
use app\models\ServicelistSearch;
use app\models\State;
use app\models\StateSearch;
use app\models\Service;
use app\models\ServiceSearch;
use app\models\ServiceListForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\Session;

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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Serviceset models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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

        if($modelForm->loadServiceList())
        {
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
        $state = new StateSearch();
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();
        $itemsState = $state -> getStateList();
        /* if($modelForm->loadServiceList())
         {
             $data = $modelForm->getServiceList($id);
             $this->saveServiceListArray($data);
             return $this->redirect(['project/view', 'id' => $this->findModel($id)->id_project]);
         }*/
        $session = Yii::$app->session;
        $address = Yii::$app->request->getReferrer();
        $pathRefer = 'project/view';
        $pathCurr = 'serviceset/create';
        $gettingId = $this->getReferrerId($address);

        if ((($this->checkPage($address, $pathRefer)) && ($this->getReferrerId($address)!= NULL)) || ($this->checkPage($address, $pathCurr))) {
            if(!ArrayHelper::keyExists('id_project', $session)) {
                $session->set('id_project', $gettingId);
           }

            if($modelForm->loadServiceList()) {
                $model = new Serviceset();
                $model->id_project = $session->get('id_project');
                $model->id_state = 1;
                $model->save();
                $id = $model->id_serviceset;
                $data = $modelForm->getServiceList($id);
                $this->saveServiceListArray($data);
                $session->remove('id_project');
                return $this->redirect(['project/view', 'id' => $model->id_project]);
            }

            return $this->render('create', [
                'itemsState' => $itemsState,
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
        $state = new StateSearch();
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();
        $itemsState = $state -> getStateList();
        $modelForm->serviceList = $this->findServiceList($id);
        $info = $this->findServiceList($id);
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_serviceset]);
            }

            return $this->render('update', [
                'model' => $model,
                'itemsState' => $itemsState,
                'modelForm' => $modelForm,
                'itemsService' => $itemsService,
                'info'=>$info,
            ]);
        } catch (StaleObjectException $e) {

            throw new StaleObjectException(Yii::t('app', 'Error data version'));
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Serviceset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Serviceset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Serviceset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findServiceList($id)
    {
        $serviceListInfo = new ServicelistSearch();
        $setInfo = $serviceListInfo->getServiceSetInfo($id);
        $arr = [];
        for ($i=0; $i<count($setInfo); $i++) {
            $arr[$i] = ['Service' =>  $setInfo[$i]['id']];
        }
        return $arr;
    }

    protected function saveServiceListArray($arr)
    {
        foreach ($arr as $item)
        {
            $model = new Servicelist();
            $model->saveServiceList($item);
        }
    }

    protected function saveNewServiceSet($project_id)
    {
        $model = new Serviceset();
        $model->id_project = $project_id;
        $model->id_state = 1;
        if(!($model->save())) {
            return NULL;
        }
        return $model->id_serviceset;
    }

    protected function getReferrerId($str)
    {
        $result = NULL;
        parse_str($str, $el);
        if(ArrayHelper::keyExists('id', $el)) {
            $result = (integer)$el['id'];
        }
        return $result;
    }

    protected function checkPage($str, $path)
    {
        $query = parse_url($str, PHP_URL_QUERY);
        parse_str($query,$el);
        //$address = 'project/view';
        if(ArrayHelper::keyExists('r', $el)) {
            return ($el['r'] === $path);
        }
        return false;
    }

}
