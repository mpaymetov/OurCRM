<?php

namespace app\api\controllers;

use Yii;
use app\service\EventService;
use yii\rest\ActiveController;
use yii\web\Response;


/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public $modelClass = 'app\models\Event';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update']);

        return $actions;
    }

    private $eventService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->eventService = new EventService();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            return ($this->eventService->getAllEvents());
        }
    }

    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            return $this->eventService->getEventViewData($id);
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            $this->eventService->setCreateEvent();
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            var_dump(\Yii::$app->request->isAjax);
            $this->eventService->setEventUpdate($id);
        }// возвращяем объект и экшн который нужно применить к объекту
        /*$action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        if ($action == 'redirect') {
            return $this->redirect(['view', 'id' => $model->id_event]);
        } elseif ($action == 'curr') {
            return $this->render('update', [
                'model' => $model,]);
        }*/
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']); //todo перенести в сервис
    }
}