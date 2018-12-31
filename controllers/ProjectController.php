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


/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{

    private $projectService;

    public function init()
    {
        $this->getService();
    }

    /**
     *
     */
    public function getService()
    {
        $this->projectService = new ProjectService();
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', $this->projectService->getAllProjects()
        );
    }

    /**
     * Displays a single Project model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', $this->projectService->getViewInfoProject($id));
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->projectService->actionProjectDeleteRequest($id)) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

}