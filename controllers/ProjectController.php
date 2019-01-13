<?php

namespace app\controllers;

use app\service\ProjectService;
use Yii;
use app\models\Project;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;



class ProjectController extends Controller
{

    private $projectService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->projectService = new ProjectService();
    }

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

    public function actionIndex()
    {
        return $this->render('index', $this->projectService->getAllProjects()
        );
    }

    public function actionView($id)
    {
        return $this->render('view', $this->projectService->getViewInfoProject($id));
    }


    public function actionCreate()
    {
        $answer = $this->projectService->setProject(); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');
        $modelForm = ArrayHelper::getValue($answer, 'modelForm');
        $itemsService = ArrayHelper::getValue($answer, 'itemsService');
        $clientList = ArrayHelper::getValue($answer, 'clientList');
        if ($action == 'redirect') {
            return $this->redirect(['view', 'id' => $model->id_project]);
        } elseif ($action == 'curr') {
            return $this->render('create', [
                'model' => $model,
                'modelForm' => $modelForm,
                'itemsService' => $itemsService,
                'clientList' => $clientList
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $answer = $this->projectService->setUpdateProject($id); // возвращяем объект и экшн который нужно применить к объекту
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');


        if ($action == 'redirect') {

            return $this->redirect(['view', 'id' => $model->id_project]);
        } elseif ($action == 'curr') {
            return $this->render('update', [
                'model' => $model,]);
        }
    }

    public function actionDelete($id)
    {
        if ($this->projectService->actionProjectDeleteRequest($id)) {
            return $this->redirect(['index']);
        }
    }


}