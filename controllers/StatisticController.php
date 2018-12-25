<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:37
 */

namespace app\controllers;

use Yii;
use app\forms\StatisticForm;
use app\forms\HeadStatisticForm;
use yii\web\Controller;
use app\service\StatisticService;
use app\service\HeadStatisticService;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use app\service\RoleService;
use app\service\UserService;

use app\service\StatisticHandler;
use yii\helpers\ArrayHelper;




class StatisticController extends Controller
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
                return $this->render('index', $model);
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'serviceset';
        return $this->handler->setDefaultChart($chartType);
    }

    public function actionRenderInitialProjectChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'project';
        return $this->handler->setDefaultChart($chartType);
    }

    public function actionRenderInitialSaleChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'sale';
        return $this->handler->setDefaultChart($chartType);
}

    public function actionRenderChartByPeriod()//TODO переименовать метод
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->handler->setChart(\Yii::$app->request->post());
    }



}