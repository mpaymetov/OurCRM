<?php

namespace app\controllers;

use Yii;
use app\db_modules\servisetDbQuery;
use app\models\StateCheck;
use yii\web\Controller;
use yii\web\Cookie;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;

/**
 * ServicesetController implements the CRUD actions for Serviceset model.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all Serviceset models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        } else {
            $searchModel = new servisetDbQuery();
            $state = new StateCheck();
            $list = $state->getStateList();
            $dataProvider = [];
            $item = [];
            for ($i = $state::MakeContact; $i <= $state::Close; $i++) {
                    $item['state'] = $list[$i];
                    $item['info'] = new ArrayDataProvider([
                        'allModels' => $searchModel->getServiceSetInfoByStateAndUser($i, Yii::$app->user->identity->id_user)
                    ]);
                    $dataProvider[] = $item;
                }

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
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