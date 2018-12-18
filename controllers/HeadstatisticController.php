<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.12.2018
 * Time: 20:51
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\forms\DatePeriodForm;
use app\service\HeadStatisticService;
use app\service\UserService;



class HeadstatisticController extends Controller
{
    private $statisticService;
    private $userService;

    public function init()
    {
        $this->getService();
        $this->getUserService();
    }

    public function getService()
    {
        $this->statisticService = new HeadStatisticService();
    }

    public function getUserService()
    {
        $this->userService = new UserService();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }
        $dateModelProject = new DatePeriodForm();
        $dateModelSale= new DatePeriodForm();
        $managerList = $this->userService->GetManagerList(Yii::$app->user->identity->id_department);


        return $this->render('index', [
            'dateModelProject' => $dateModelProject,
            'dateModelSale' => $dateModelSale,
            'managerList' => $managerList
        ]);
    }


    public function actionRenderInitialServicesetChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $chartType = 'serviceset';
        $data = $this->statisticService->getServicesetNumByAllManagerInfo();

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