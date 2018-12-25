<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 22.12.2018
 * Time: 16:40
 */

namespace app\service;

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



class StatisticHandler
{
    private $statisticService;
    private $headStatisticService;
    private $userService;
    private $roleService;

    public function isHeadStatistic()
    {
        $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id_user);
        return (array_key_exists('admin', $role) || array_key_exists('leader', $role));
    }

    public function  isStatistic()
    {
        $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id_user);
        return (array_key_exists('manager', $role));
    }

    public function isNotStatistic()
    {
        $role = $this->roleService->getRole();
        return (array_key_exists('baserole', $role));
    }

    public function __construct()
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

    public function setStatisticIndex()
    {
        if (Yii::$app->user->isGuest) {
            return ['action' => 'login', 'model' => null];
        }

        if ($this->isNotStatistic()) {
            return ['action' => 'mainPage', 'model' => null];
        }

        $dateModelProject = $this->getFormByRole();
        $dateModelSale = $this->getFormByRole();
        $idDepartment = Yii::$app->user->identity->id_department;
        $managerList = $this->userService->GetManagerList($idDepartment);
        $statisticType = $this->getStatisticType();

        return ['action' => 'current', 'model' => [
            'dateModelProject'=>$dateModelProject,
            'dateModelSale'=>$dateModelSale,
            'managerList' => $managerList,
            'statisticType' => $statisticType,
        ]];
    }

    public function setDefaultChart($type)
    {
        $service = $this->getServiceByRole();
        $date = $service->getInitalPeriod($type);
        $data = $service->getChartInfo($date);
        $chartType = null;

        if(($type == 'serviceset') || ($type == 'project')) {
            $chartType = 'ColumnChart';
        } elseif ($type == 'sale') {
            $chartType = 'LineChart';
        }

        $response = [
            'name' => $type,
            'chart' => $chartType,
            'data' => $data,
            'error' => empty($data) //TODO сделать обработку ошибок при получении data
        ];

        return $response;
    }

    public function setChart($request)
    {
        $service = $this->getServiceByRole();
        $dateModel = $this->getFormByRole();
        $response = [];

        if ((Yii::$app->request->isAjax)&&($dateModel->load($request))){
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