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
            $eventDataProvider = $eventSearchModel->search(Yii::$app->request->queryParams);
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

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = 'Привет')
    {
        return $this->render('say', ['message' => $message]);
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

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
