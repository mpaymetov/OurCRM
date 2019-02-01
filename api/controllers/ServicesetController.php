<?php

namespace app\api\controllers;


use Yii;
use yii\rest\ActiveController;
use app\models\Serviceset;
use app\models\Servicelist;
use app\models\StateCheck;
use app\forms\ServiceListForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use app\service\ServicesetHandler;
use app\service\ServiceListFormHandler;


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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public $modelClass = 'app\models\Serviceset';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update']);

        return $actions;
    }

    public function actionCreate()
    {
        $answer = $this->setHandler->createServiceset();
        $action = ArrayHelper::getValue($answer, 'action');
        $modelForm = ArrayHelper::getValue($answer, 'modelForm');
        $id = ArrayHelper::getValue($answer, 'id');

        if ($action == 'redirect') {
            return $this->redirect(['project/view', 'id' => $id]);
        } elseif ($action == 'current') {
            return [$model =>[
                'modelForm' => $modelForm,
                'itemsService' => $this->setHandler->getServiceListItems()]
            ];
        } elseif ($action == 'home') {
            return $this->redirect(['site/index']);
        }
    }

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

    protected
    function findModel($id)
    {
        if (($model = Serviceset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
