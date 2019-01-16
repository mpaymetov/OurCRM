<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:37
 */

namespace app\api\controllers;

use Yii;
use app\forms\StatisticForm;
use app\forms\HeadStatisticForm;
use yii\rest\ActiveController;
use app\service\StatisticService;
use app\service\HeadStatisticService;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use app\service\RoleService;
use app\service\UserService;

use app\service\StatisticHandler;
use yii\helpers\ArrayHelper;




class StatisticController extends ActiveController
{
    private $handler;

    public function init()
    {
        $this->getStatisticHandler();
    }

    private function getStatisticHandler()
    {
        $this->handler = new StatisticHandler();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public $modelClass = 'app\forms\StatisticForm';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index'], $actions['view'], $actions['create'], $actions['delete']);

        return $actions;
    }

    public function actionIndex()
    {
        $answer = $this->handler->setStatisticIndex();
        $action = ArrayHelper::getValue($answer, 'action');
        $model = ArrayHelper::getValue($answer, 'model');

        switch ($action) {
            case 'login':
                return Yii::$app->getResponse()->redirect(array('/user/login', 302));
                break;
            case 'current':
                return ['model' => $model]; //$this->handler->setStatisticIndex();
                break;
            case 'mainPage':
                return $this->redirect(['site/index']);
                break;
            default:
                return $this->redirect(['site/index']);
                break;
        }
    }

    public function actionRenderInitialServicesetChart()
    {
        $chartType = 'serviceset';
        return $this->handler->setDefaultChart($chartType);
    }

    public function actionRenderInitialProjectChart()
    {
        $chartType = 'project';
        return $this->handler->setDefaultChart($chartType);
    }

    public function actionRenderInitialSaleChart()
    {
        $chartType = 'sale';
        return $this->handler->setDefaultChart($chartType);
}

    public function actionRenderChartByPeriod()//TODO переименовать метод
    {
        return $this->handler->setChart(\Yii::$app->request->post());
    }



}