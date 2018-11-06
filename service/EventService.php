<?php

namespace app\service;

use app\controllers\SecurityController;
use Yii;
use app\models\Event;
use app\models\EventSearch;


class EventService extends SecurityController
{
    public static function actionEventIndexRequest()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }

    public static function actionEventViewRequest($id)
    {
        $searchModel = new EventSearch();
        $model = $searchModel->findModel($id);
        return ['model' => $model];
    }

    public static function actionEventUpdateRequest($id)
    {
        $session = Yii::$app->session;
        $session->set('id_event', $id);
        $search = new EventSearch();
        $model = $search->findModel($id);
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
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return  ['model' => $model, 'action' => 'redirect'];
            };
            return ['model' => $model, 'action' => 'curr'];
        } catch
        (StaleObjectException $e) {
            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }


}