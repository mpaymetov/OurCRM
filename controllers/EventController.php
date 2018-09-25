<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();
        //проверку id user проводить вызовом метода из класса безопасности
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_event]);
            }
        } else {
            // тут вызов метода из класса безопасности
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        try {
            if (\Yii::$app->request->isAjax) {
                if ($model->is_active == 0) {
                    $model->is_active = 1;
                } else {
                    $model->is_active = 0;
                };
                $model->save();
                return ("OK");
            }

            var_dump(property_exists($model, 'id_client'));
            $model2 = new Event();
            $model2->load(Yii::$app->request->post());
            switch ($model2->id_link . $model2->link) {
                case '':
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                    break;
                case $model->id_link . $model->link:
                    if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id_event]);
                    };
                    break;
                default:
                    return $this->render('update', [
                        'model' => $model,
                    ]);

<<<<<<< HEAD
            if (SecurityController::validateParam1($model, $model2)) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id_event]);
                };
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
=======
>>>>>>> parent of d532fda... Набросок Security
            }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_event]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);

        } catch (StaleObjectException $e) {

            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }

    /**
     * Deletes an existing Event model.
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
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            if ($model->id_user == Yii::$app->user->identity->id_user) {
                return $model;
            }
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function eventState($id_event)
    {
        $model = findModel($id_event);
        if ($model->is_active == true) {
            $model->is_active = false;
            $model->save();
        } else {
            $model->is_active == true;
            $model->save();
        }

    }
}
