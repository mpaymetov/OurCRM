<?php

namespace app\controllers;

use app\models\EventSearch;
use app\models\ProjectSearch;
use Yii;
use yii\web\Controller;

class EventsNotComplitedController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/site/login', 302));
        } else {
            $eventSearchModel = new eventSearch();
            $eventDataProvider = $eventSearchModel->searchNotDoneEvent(Yii::$app->request->queryParams, 'index');
            $eventDataProvider->query->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user);
            $projectSearchModel = new ProjectSearch();
            $projectDataProvider = $projectSearchModel->searchNotDoneProject(Yii::$app->request->queryParams, 'index');
            $projectDataProvider->query->andWhere('project.id_user = ' . Yii::$app->user->identity->id_user);

            return $this->render('index',
                [
                    'eventSearchModel' => $eventSearchModel,
                    'eventDataProvider' => $eventDataProvider,
                    'projectSearchModel' => $projectSearchModel,
                    'projectDataProvider' => $projectDataProvider
                ]);
        }
    }
}

