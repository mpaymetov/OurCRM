<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\service\EventService;
use yii\helpers\ArrayHelper;
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
    public $serializer = [
            'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
/*
    private $eventService;

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
        return $this->render('index', $this->eventService->getAllEvents());
    }


    public function actionView($id)
    {
        return $this->render('view', $this->eventService->getEventViewData($id)
        );
    }


    public function actionCreate()
    {
        $answer = $this->eventService->setCreateEvent(); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        if ($action == 'redirect') {
            return $this->redirect(['view', 'id' => $model->id_event]);
        } elseif ($action == 'curr') {
            return $this->render('create', [
                'model' => $model,]);
        }
    }


    public function actionUpdate($id)
    {
        $answer = $this->eventService->setEventUpdate($id); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        if ($action == 'redirect') {
            return $this->redirect(['view', 'id' => $model->id_event]);
        } elseif ($action == 'curr') {
            return $this->render('update', [
                'model' => $model,]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']); //todo перенести в сервис
    }

*/
}