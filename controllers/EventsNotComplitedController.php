<?php

namespace app\controllers;

use app\models\EventSearch;
use Yii;

class EventsNotComplitedController extends SecurityController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/site/login', 302));
        } else {
            $eventSearchModel = new eventSearch();
            $eventDataProvider = $eventSearchModel->searchNotDoneEvent(Yii::$app->request->queryParams, 'index');
            $eventDataProvider->query->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user);

            return $this->render('index',
                [
                    'eventSearchModel' => $eventSearchModel,
                    'eventDataProvider' => $eventDataProvider,
                ]);
        }
    }
}

