<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 21.11.2018
 * Time: 10:05
 */

namespace app\service;

use app\db_modules\HeadStatisticDbQuery;
use app\db_modules\StatisticDbQuery;
use app\service\DateService;


class HeadStatisticService
{
    private $dbHeadQuery;
    private $dbQuery;
    private $dateService;



    public function __construct()
    {
        $this->setDbQuery(new StatisticDbQuery());
        $this->setDbHeadQuery(new HeadStatisticDbQuery());
        $this->setDateService(new DateService());
    }

    public function setDbQuery($param)
    {
        $this->dbQuery = $param;
    }

    public function setDbHeadQuery($param)
    {
        $this->dbHeadQuery = $param;
    }

    public function setDateService($param)
    {
        $this->dateService = $param;
    }

    public function getServicesetNumByAllManagerInfo()
    {
        $query = $this->dbHeadQuery->getServicesetNumByStateAndDepartment(Yii::$app->user->identity->id_department);

        if(empty($query)) {
            return null;
        }

        $state = new StateCheck();
        $list = $state->getStateList();
        $result = [['state', 'num']];
        $find = false;
        $num = -1;

        for($i = $state::MakeContact; $i <= $state::Delivery; $i++)
        {
            foreach ($query as $el) {
                $find = ($el['state'] == $i);
                $num++;
                if($find) {
                    break;
                }
            }

            if($find)
            {
                $arrEl = [(string)$list[$i],  (int)$query[$num]['num']];
            } else {
                $arrEl = [(string)$list[$i], (int)0];
            }

            array_push($result, $arrEl);
            $find = false;
            $num = -1;
        }

        return $result;
    }

    public function getProjectNumByAllManager($idDepartment, $datePeriod)
    {
        $query = $this->dbHeadQuery->getProjectNumberByDepartmentForPeriod($idDepartment, $datePeriod->from, $datePeriod->to);
        $columns = ['month', 'all', 'close', 'cancellation'];

        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;

    }

    public function getSalesForByAllManager($idDepartment, $datePeriod)
    {
        $query = $this->dbHeadQuery->getSalesByDepartmentForPeriod($idDepartment, $datePeriod->from, $datePeriod->to);
        $columns = ['month', 'sale'];

        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;

    }

    public function getProjectNumByStateForPeriod($datePeriod)
    {
        $query = $this->dbQuery->getProjectNumberForPeriod($datePeriod->user, $datePeriod->from, $datePeriod->to);

        $columns = ['month', 'all', 'close', 'cancellation'];

        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;
    }

    public function getSalesForLastPeriod($datePeriod)
    {
        $query = $this->dbQuery->getSalesForPeriod($datePeriod->user, $datePeriod->from, $datePeriod->to);

        $columns = ['month', 'sale'];

        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;
    }



    public function getChartInfoByPeriod($datePeriod)
    {
        $result = null;

        if ($datePeriod->id_user != null) {
            switch ($datePeriod->type) {
                case 'project':
                    $result = $this->getProjectNumByStateForPeriod($datePeriod);
                    break;
                case 'sale':
                    $result = $this->getSalesForLastPeriod($datePeriod);
                    break;
                default:
                    return false;
            }
        } else {
            switch ($datePeriod->type) {
                case 'project':
                    $result = $this->getProjectNumByAllManager(Yii::$app->user->identity->id_department, $datePeriod);
                    break;
                case 'sale':
                    $result = $this->getSalesForByAllManager(Yii::$app->user->identity->id_department, $datePeriod);
                    break;
                default:
                    return false;
            }
        }

        return $result;
    }

    public function getInitalPeriod($type)
    {
        $date = new DatePeriodForm();
        $currDate = new DateTime;
        $date->to = $currDate->format('Y-m-d');
        $currDate->sub(DateInterval::createFromDateString('1 year'));
        $date->from = $currDate->format('Y-m-d');;
        $date->type = $type;
        $date->user = null;
        return $date;
    }

}