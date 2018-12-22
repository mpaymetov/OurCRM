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

    private function isHeadStatistic()
    {
        $role = $this->roleService->getRole();
        return (array_key_exists('admin', $role) || array_key_exists('leader', $role));
    }

    private function  isStatistic()
    {
        $role = $this->roleService->getRole();
        return (array_key_exists('manager', $role));
    }

    private function isNotStatistic()
    {
        $role = $this->roleService->getRole();
        return (array_key_exists('baserole', $role));
    }

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
        if ($this->isHeadStatistic()) {
            return $this->headStatisticService;
        } elseif ($this->isStatistic()) {
            return $this->statisticService;
        }
    }

    public function getFormByRole()
    {
        if ($this->isHeadStatistic()) {
            $form = new HeadStatisticForm();
            return $form;
        } elseif ($this->isStatistic()) {
            $form = new StatisticForm();
            return $form;
        }
    }

    public function getStatisticType()
    {
        if ($this->isHeadStatistic()) {
            return 'headStatistic';
        } elseif ($this->isStatistic()) {
            return 'statistic';
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }

        if ($this->isNotStatistic()) {
            return $this->redirect(['site/index']);
        }

        $dateModelProject = $this->getFormByRole();
        $dateModelSale = $this->getFormByRole();
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
        $service = $this->getServiceByRole();
        $chartType = 'serviceset';
        $date = $service->getInitalPeriod($chartType);
        $data = $service->getServicesetNumByStateInfo($date);

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
        $service = $this->getServiceByRole();
        $chartType = 'project';
        $date = $service->getInitalPeriod($chartType);
        $data = $service->getChartInfo($date);

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
        $service = $this->getServiceByRole();
        $chartType = 'sale';
        $date = $service->getInitalPeriod($chartType);
        $data = $service->getChartInfo($date);

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
        $service = $this->getServiceByRole();
        $dateModel = $this->getFormByRole();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];

        if ((Yii::$app->request->isAjax)&&($dateModel->load(\Yii::$app->request->post()))){
           if($dateModel->validate() && $dateModel->dateCheck()) {
                $response['info'] = $service->getChartInfo($dateModel);
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