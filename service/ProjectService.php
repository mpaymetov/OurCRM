<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 07.11.2018
 * Time: 2:49
 */

namespace app\service;

use Yii;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\ServicesetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\models\EventSearch;
use yii\db\StaleObjectException;
use app\db_modules\servisetDbQuery;

class ProjectService
{
    public static function actionProjectIndexRequest()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public static function actionProjectViewRequest($id)
    {
        $searchModel = new ServicesetSearch();
        $dataProvider = $searchModel->searchProjectById($id);
        $servicesetData = new servisetDbQuery();
        $servicesetInfo = $servicesetData->getServiceSetInfoByProjectId($id);
        $serviceListDataProvider = [];
        for ($i = 0; $i < count($servicesetInfo); $i++) {
            $info = $servicesetInfo[$i];
            $serviceListDataProvider[$i] = array(
                'ServiceSetInfo' => new ArrayDataProvider([
                    'allModels' => array(
                        0 => $info),
                ]),
                'ServiceListInfo' => new ArrayDataProvider([
                    'allModels' => $servicesetData->getServiceSetInfo($info['id']),
                ]),
            );
        }

        $searchEventModel = new EventSearch();
        $eventDataProvider = $searchEventModel->searchEventId($id, Yii::$app->user->identity->id_user, 2);
        $search = new ProjectSearch();
        return [
            'model' => $search->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'eventDataProvider' => $eventDataProvider,
            'serviceListDataProvider' => $serviceListDataProvider,
        ];
    }

    public static function actionProjectCreateRequest()
    {

        $model = new Project();
        $dataControl = new DataControlService();
        $startParams = new StartParamsService();
        $startParams->takeStartParams($model);
        if ($dataControl->dataControl($model)) {
            var_dump($model->save());
            var_dump($model->load(Yii::$app->request->post()));
            var_dump($model->errors);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['model' => $model, 'action' => 'redirect'];
            }
        }
        return ['model' => $model, 'action' => 'curr'];
    }

    public static function actionProjectUpdateRequest($id)
    {
        $session = Yii::$app->session;
        $session->set('id_project', $id);
        $search = new ProjectSearch();
        $dataControl = new DataControlService();
        $model = $search->findModel($id);
        try {
            if ($dataControl->dataControl($model)) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return ['model' => $model, 'action' => 'redirect'];
                };
            }
            return [
                'model' => $model, 'action' => 'curr'
            ];

        } catch
        (StaleObjectException $e) {
            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }

    public static function actionProjectDeleteRequest($id)
    {
        $search = new ProjectSearch();
        $search->findModel($id)->delete();
        return true;
    }
}
