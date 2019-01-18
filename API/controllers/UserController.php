<?php

namespace app\api\controllers;

use Yii;
use app\service\UserService;
use app\forms\LoginForm;
use app\forms\SignupForm;
use app\forms\ResetForm;
use app\forms\CreateForm;
use app\forms\ViewForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use app\service\RbacService;
use app\service\DepartmentService;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $layout = '@app/views/layouts/user.php';

    private $userService;
    private $rbacService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->userService = new UserService();
        $this->rbacService = new RbacService();
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', $this->userService->actionUserIndexRequest());
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->userService->actionUserViewRequest($id),
        ]);
    }

    /**
     * Disable a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDisable($id)
    {
        $user = UserService::disableUser($id);

        return $this->redirect(['view', 'id' => $user->id_user]);
    }

    /**
     * Enable a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEnable($id)
    {
        $user = UserService::enableUser($id);

        return $this->redirect(['view', 'id' => $user->id_user]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->create()) {
                $this->redirect(['view', 'id' => $user->id_user]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new ViewForm();
        try {
            if ($model->load(Yii::$app->request->post())) {
                $model->id = $id;
                if ($user = $model->update()) {
                    return $this->redirect(['view', 'id' => $user->id_user]);
                }
            }

            return $this->render('update', [
                'model' => $this->userService->actionUserViewRequest($id),
            ]);
        } catch (StaleObjectException $e) {

            throw new StaleObjectException(Yii::t('app', 'Error data version'));
        }
    }

    public function actionReset($id)
    {
        $model = new ResetForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->reset($id)) {
                return $this->redirect(['view', 'id' => $user->id_user]);
            }
        }

        $model->login = UserService::findLoginById($id);

        return $this->render('reset', [
            'model' => $model,
        ]);
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
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
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

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($id);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserService::findModel($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
