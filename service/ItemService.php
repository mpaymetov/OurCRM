<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20.12.2018
 * Time: 2:06
 */

namespace app\service;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\Cookie;

use app\models\ContactForm;
use app\models\ClientSearch;
use app\models\ProjectSearch;
use app\models\UserSearch;
use app\models\EventSearch;
use app\models\Role;
use app\models\RoleSearch;

class ItemService
{
    public function getAllItems()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/site/login', 302));
        } else {
            $searchModel = new ClientSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere('client.id_user = ' . Yii::$app->user->identity->id_user);

            $projectSearchModel = new ProjectSearch();
            $projectDataProvider = $projectSearchModel->search(Yii::$app->request->queryParams);
            $projectDataProvider->query->andWhere('project.id_user = ' . Yii::$app->user->identity->id_user);

            $userSearchModel = new userSearch();
            $userDataProvider = $userSearchModel->search(Yii::$app->request->queryParams);

            /*$roleSearchModel = new roleSearch();
            if ($roleSearchModel->getUserReadAll()) {} else */
            {
                $userDataProvider->query->andWhere('user.id_user = ' . Yii::$app->user->identity->id_user);
            }

            $eventSearchModel = new eventSearch();
            $eventDataProvider = $eventSearchModel->search(Yii::$app->request->queryParams, 'index');
            $eventDataProvider->query->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user);

            return
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'projectSearchModel' => $projectSearchModel,
                    'projectDataProvider' => $projectDataProvider,
                    'userSearchModel' => $userSearchModel,
                    'userDataProvider' => $userDataProvider,
                    'eventSearchModel' => $eventSearchModel,
                    'eventDataProvider' => $eventDataProvider,
                ];
        }
    }
}