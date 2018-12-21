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




class StatisticController extends Controller
{

    private $statisticService;
    private $headStatisticService;
    private $userService;
    private $roleService;

    public function init()
    {
        $this->getStatisticService();
        $this->getHeadStatisticService();
        $this->getUserService();
        $this->getRoleService();
    }

    public function getStatisticService()
    {
        $this->statisticService = new StatisticService();
    }

    public function getHeadStatisticService()
    {
        $this->headStatisticService = new HeadStatisticService();
    }

    public function getUserService()
    {
        $this->userService = new UserService();
    }

    public function getRoleService()
    {
        $this->roleService = new RoleService();
    }

    public function getServiceByRole()
    {
        $role = $this->roleService->getRole();
        if ($role == 'leader' || $role == 'admin') {
            return $this->headStatisticService;
        } elseif ($role == 'manager') {
            return $this->statisticService;
        }
    }

    public function getFormByRole()
    {
        $role = $this->roleService->getRole();
        if ($role == 'leader' || $role == 'admin') {
            $form = new HeadStatisticForm();
            return $form;
        } elseif ($role == 'manager') {
            $form = new StatisticForm();
            return $form;
        }
    }

    public function getStatisticType()
    {
        $role = $this->roleService->getRole();
        if ($role == 'leader' || $role == 'admin') {
            return 'headStatistic';
        } elseif ($role == 'manager') {
            return 'statistic';
        }
    }


    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }

        if ($this->roleService->getRole() == 'baserole') {
            return $this->redirect(['site/index']);
        }

        $dateModelProject = new HeadStatisticForm();// $this->getFormByRole();
        $dateModelSale = new HeadStatisticForm();// $this->getFormByRole();
        print_r($this->roleService->getRole());
        $managerList = $this->userService->GetManagerList(Yii::$app->user->identity->id_department);
        $statisticType = $this->getStatisticType();

        return $this->render('index', [
            'dateModelProject'=>$dateModelProject,
            'dateModelSale'=>$dateModelSale,
            'managerList' => $managerList,
            'statisticType' => $statisticType,
        ]);
    }


    public function actionRenderInitialServicesetChart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $servise = $this->getServiceByRole();
        $chartType = 'serviceset';
        $date = $this->headStatisticService->getInitalPeriod($chartType);
        $data = $this->headStatisticService->getServicesetNumByStateInfo($date);

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
        $servise = $this->getServiceByRole();
        $chartType = 'project';
        $date = $this->headStatisticService->getInitalPeriod($chartType);
        $data = $this->headStatisticService->getChartInfo($date);

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
        $servise = $this->getServiceByRole();
        $chartType = 'sale';
        $date = $this->headStatisticService->getInitalPeriod($chartType);
        $data = $this->headStatisticService->getChartInfo($date);

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
        $dateModel = new HeadStatisticForm();
       // $dateModel->department = Yii::$app->user->identity->id_department;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];

        if ((Yii::$app->request->isAjax)&&($dateModel->load(\Yii::$app->request->post()))){
           $dateModel->department = Yii::$app->user->identity->id_department;
           if($dateModel->validate() && $dateModel->dateCheck()) {
                $response['info'] = $this->headStatisticService->getChartInfo($dateModel);
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