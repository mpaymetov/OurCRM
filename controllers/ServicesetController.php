<?php

namespace app\controllers;

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
        $model = new Serviceset();
        $state = new StateSearch();
        $modelForm = new ServiceListForm();
        $service = new ServiceSearch();
        $itemsService = $service->getServiceListItems();
        $itemsState = $state -> getStateList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_serviceset]);
        }

        return $this->render('create', [
            'model' => $model,
            'itemsState' => $itemsState,
            'modelForm' => $modelForm,
            'itemsService' => $itemsService,
        ]);
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
        //$modelForm->serviceList = ['Service' => $this->findServiceList($id)];
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

    public function saveServiceListArray($arr)
    {
        foreach ($arr as $item)
        {
            $model = new Servicelist();
            $model->saveServiceList($item);
        }
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

        return ArrayHelper::getColumn($setInfo, 'id');
    }
}
