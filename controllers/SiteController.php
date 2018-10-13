<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use app\models\Serviceset;
use app\models\ServicesetSearch;
use app\models\Servicelist;
use app\models\ServicelistSearch;
use app\models\Service;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\State;
use app\models\ServiceSearch;
use app\models\ServiceListForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
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
            return Yii::$app->getResponse()->redirect(array('/site/login', 302));
        } else {
            $searchModel = new ServicesetSearch();
            $state = new State();
            $list = $state->getStateList();
            $dataProvider = [];
            $item = [];
            for ($i = 0; $i < count($list) - 1; $i++) {
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


}