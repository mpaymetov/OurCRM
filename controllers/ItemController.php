<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\Cookie;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\ClientSearch;
use app\models\ProjectSearch;
use app\models\UserSearch;
use app\models\EventSearch;
use app\models\Role;
use app\models\RoleSearch;

class ItemController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
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

            $roleSearchModel = new roleSearch();
            if ($roleSearchModel->getUserReadAll()) {} else {
                $userDataProvider->query->andWhere('user.id_user = ' . Yii::$app->user->identity->id_user);
            }

            $eventSearchModel = new eventSearch();
            $eventDataProvider = $eventSearchModel->search(Yii::$app->request->queryParams, 'index');
            $eventDataProvider->query->andWhere('event.id_user = ' . Yii::$app->user->identity->id_user);

            return $this->render('index',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'projectSearchModel' => $projectSearchModel,
                    'projectDataProvider' => $projectDataProvider,
                    'userSearchModel' => $userSearchModel,
                    'userDataProvider' => $userDataProvider,
                    'eventSearchModel' => $eventSearchModel,
                    'eventDataProvider' => $eventDataProvider,
                ]);
        }
    }


}
