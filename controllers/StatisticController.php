<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:37
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\forms\DatePeriodForm;
use yii\web\Controller;
use app\service\StatisticService;
use app\db_modules\StatisticDbQuery;
use app\service\RequestHandler;
use yii\bootstrap\ActiveForm;
use yii\web\Response;



class StatisticController extends Controller
{

    private $statisticService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->statisticService = new StatisticService();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }
        $dateModelProject = new DatePeriodForm();
        $dateModelSale= new DatePeriodForm();

        return $this->render('index', [
            'dateModelProject'=>$dateModelProject,
            'dateModelSale'=>$dateModelSale
        ]);
    }


    public function actionRenderInitialServicesetChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'serviceset';
        $date = $this->statisticService->getInitalPeriod($chartType);
        $data = $this->statisticService->getChartInfoByPeriod($date);

        $response = [
            'name' => $chartType,
            'chart' => 'ColumnChart',
            'data' => $data,
            'error' => empty($data)
        ];
        return $response;
    }

    public function actionRenderInitialProjectChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'project';
        $date = $this->statisticService->getInitalPeriod($chartType);
        $data = $this->statisticService->getChartInfoByPeriod($date);

        $response = [
            'name' => $chartType,
            'chart' => 'ColumnChart',
            'data' => $data,
            'error' => empty($data)
        ];
        return $response;
    }

    public function actionRenderInitialSaleChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'sale';
        $date = $this->statisticService->getInitalPeriod($chartType);
        $data = $this->statisticService->getChartInfoByPeriod($date);

        $response = [
            'name' => $chartType,
            'chart' => 'LineChart',
            'data' => $data,
            'error' => empty($data)
        ];
        return $response;

    }



    public function actionRenderChartByPeriod()
    {
        $dateModel = new DatePeriodForm();
        $dateModel->user = Yii::$app->user->identity->id_user;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];

        if ((Yii::$app->request->isAjax)&&($dateModel->load(\Yii::$app->request->post()))){
           if($dateModel->validate()) {
                $response['info'] = $this->statisticService->getChartInfoByPeriod($dateModel);
                $response['type'] = $dateModel->type;
                if ($response['info'] != null)
                {
                    $response['success'] = 'success';
                    $response['error'] = null;
                } else {
                    $response['success'] = null;
                    $response['error'] = 'error';
                }
           } else {
               return ActiveForm::validate($dateModel);
           }
        }

        return $response;
    }

}