<?php

namespace app\api\controllers;

use app\service\MainService;
use Yii;
use yii\web\Cookie;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;


class FunnelController extends ActiveController
{

    public $modelClass = 'app\models\Event';


    private $mainService;

    public function init()
    {
        $this->getService(new MainService());
    }


    public function getService($service)
    {
        $this->mainService = $service;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
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

    public function actions()
    {$actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index']);
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


    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            return(json_encode($this->mainService->getMainItems(), JSON_UNESCAPED_UNICODE));
        }
    }

    public function actionLanguage()
    {
        $language = Yii::$app->request->post('language');
        Yii::$app->language = $language;
        $languageCookie = new Cookie([
            'name' => 'language',
            'value' => $language,
            'expire' => time() + 60 * 60 * 24 * 30,
        ]);
        Yii::$app->response->cookies->add($languageCookie);
        return $this->redirect(Yii::$app->request->referrer);
    }


}