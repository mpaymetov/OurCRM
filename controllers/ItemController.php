<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Role;
use app\models\RoleSearch;
use app\service\ItemService;


class ItemController extends Controller
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
     *
     * public function init()
    {
    $this->getService();
    }

    /**
     *
     */
    private $itemService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->itemService = new ItemService();
    }



    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/site/login', 302));
        } else {

            $arr = $this->itemService->getAllItems();
            $searchModel = ArrayHelper::getValue($arr, 'searchModel');
            $dataProvider = ArrayHelper::getValue($arr, 'dataProvider');
            $projectSearchModel = ArrayHelper::getValue($arr, 'projectSearchModel');
            $projectDataProvider= ArrayHelper::getValue($arr, 'projectDataProvider');
            $userSearchModel = ArrayHelper::getValue($arr, 'userSearchModel');
            $userDataProvider = ArrayHelper::getValue($arr, 'userDataProvider');
            $eventSearchModel = ArrayHelper::getValue($arr, 'eventSearchModel');
            $eventDataProvider = ArrayHelper::getValue($arr, 'eventDataProvider');

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
