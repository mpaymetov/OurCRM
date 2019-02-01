<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 10.01.2019
 * Time: 20:31
 */

namespace app\api\controllers;

use app\api\services\ProjectService;
use app\service\EventService;
use Yii;
use app\models\Project;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\Response;


class ProjectController extends ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index'], $actions['view']);

        return $actions;
    }

    public $modelClass = 'app\models\project';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    private $projectService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->projectService = new ProjectService();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            return ($this->projectService->getAllProjects());
        }
    }

    public function actionView($id)
    {
        return ['items' => $this->projectService->getViewInfoProject($id)];
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
