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
        $this->setHandler->closeServiceset($id);
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionCancel($id)
    {
        $this->setHandler->cancelServiceset($id);
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionChangeState()
    {
        $message = $this->setHandler->changeServicesetState();
        echo json_encode($message);
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
