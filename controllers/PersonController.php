<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.12.2018
 * Time: 17:34
 */

namespace app\controllers;

use Yii;
use app\models\Person;
use yii\web\Controller;
use app\service\PersonService;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\StaleObjectException;

class PersonController extends Controller
{

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

    private $service;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->service = new PersonService();
    }

    public function actionViewAll($id)
    {

        $model = $this->service->GetAllPersonList($id);
        return $this->render('view', [
            'model'=>$model
        ]);

    }

    public function actionCreate()
    {
        $model = new Person();

        if($model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $idClient = \Yii::$app->session->get('id_client');
            $model->id_client = $idClient;
            if ($model->main == true) {
                $oldModel = Person::find()
                    ->andWhere([
                        'id_client' => $idClient,
                        'main' => 1
                    ])
                    ->one();
                if(count($oldModel) != 0) {
                    $oldModel->main = 0;
                    $oldModel->save();
                    $model->last_main = $oldModel->id_person;
                }
            }
            $model->save();
            return $this->redirect(['client/view', 'id' => $idClient]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldMain = $model->main;
        if($model->load(\Yii::$app->request->post()) && $model->validate())
        {
            if($oldMain != $model->main) {
                if ($model->main == true) {
                    $oldModel = Person::find()
                        ->andWhere([
                            'id_client' => $model->id_client,
                            'main' => 1
                        ])
                        ->one();
                    if($oldModel->id_person != $model->id_person)
                    $oldModel->main = 0;
                    $oldModel->save();
                    $model->last_main = $oldModel->id_person;
                } else {
                    $oldModel = $this->findModel($model->last_main);
                    $oldModel->main = 1;
                    $oldModel->save();
                }
            }
            $model->save();
            return $this->redirect(['client/view', 'id' => $model->id_client]);
        }

        return $this->render('create', [
            'model' => $model
        ]);

    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->main == 1) {
            $oldModel = $this->findModel($model->last_main);
            $oldModel->main = 1;
            $oldModel->save();
        }
        $model->delete();
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
                return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}