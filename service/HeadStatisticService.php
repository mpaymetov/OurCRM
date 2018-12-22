<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 21.11.2018
 * Time: 10:05
 */

namespace app\service;

use yii;
use DateInterval;
use DateTime;
use app\models\StateCheck;
use app\db_modules\HeadStatisticDbQuery;
use app\service\DateService;
use app\forms\HeadStatisticForm;
use app\service\StatisticService;


class HeadStatisticService
{
    private $dbHeadQuery;
    private $statisticService;
    private $dateService;
    private $date;

    public function __construct()
    {
        $this->setStatisticService(new StatisticService());
        $this->setDbHeadQuery(new HeadStatisticDbQuery());
        $this->setDateService(new DateService());
        $this->setDate(new HeadStatisticForm());
    }

    public function setStatisticService($param)
    {
        $this->statisticService = $param;
    }

    public function setDbHeadQuery($param)
    {
        $this->dbHeadQuery = $param;
    }

    public function setDateService($param)
    {
        $this->dateService = $param;
    }

    public function setDate($param)
    {
        $this->date = $param;
    }

    public function getServicesetNumByStateInfo($datePeriod)
    {
        $query = $this->dbHeadQuery->getServicesetNumByStateAndDepartment($datePeriod->department);

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

    public function getProjectNumByAllManager($datePeriod)
    {
        $query = $this->dbHeadQuery->getProjectNumberByDepartmentForPeriod($datePeriod->department, $datePeriod->from, $datePeriod->to);
        $columns = ['month', 'all', 'close', 'cancellation'];
        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;

    }

    public function getSalesForByAllManager($datePeriod)
    {
        $query = $this->dbHeadQuery->getSalesByDepartmentForPeriod($datePeriod->department, $datePeriod->from, $datePeriod->to);
        $columns = ['month', 'sale'];

        $result = $this->dateService->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;

    }

    public function checkFormInfo($datePeriod)
    {
        if (!$datePeriod->dateCheck()) {
            return 'error';
        }

        if (($datePeriod->from == null) xor ($datePeriod->to == null)) {
            return 'error';
        }


        $result = [];

        $period = (($datePeriod->from != null) && ($datePeriod->to != null)) ? 'period' : 'year';
        array_push($result, $period);

        $user = (($datePeriod->user != 0) ? 'one' : 'all');
        array_push($result, $user);

        return $result[0] . '-' . $result[1];
    }

    public function getChartInfoForAll($datePeriod)
    {
        $result = null;
        switch ($datePeriod->type){
            case 'project':
                $result = $this->getProjectNumByAllManager($datePeriod);
                break;
            case 'sale':
                $result = $this->getSalesForByAllManager($datePeriod);
                break;
            default:
                return false;
        }

        return $result;

    }

    public function getChartInfoForOne($datePeriod)
    {
        $result = null;
        switch ($datePeriod->type){
            case 'project':
                $result = $this->statisticService->getProjectNumByStateForPeriod($datePeriod);
                break;
            case 'sale':
                $result = $this->statisticService->getSalesForLastPeriod($datePeriod);
                break;
            default:
                return false;
        }

        return $result;
    }


    public function getChartInfo($datePeriod)
    {
        $result = null;
        $datePeriod->department = Yii::$app->user->identity->id_department;
        $check = $this->checkFormInfo($datePeriod);
        $defaultPeriod = $this->getInitalPeriod($datePeriod->type);
        switch ($check) {
            case 'period-one':
                $result = $this->getChartInfoForOne($datePeriod);
                break;
            case 'period-all':
                $result = $this->getChartInfoForAll($datePeriod);
                break;
            case 'year-one':
                $defaultPeriod->user = $datePeriod->user;
                $result = $this->getChartInfoForOne($defaultPeriod);
                break;
            case 'year-all':
                $result = $this->getChartInfoForAll($defaultPeriod);
                break;
            case 'error':
                $result = 'error';
                break;
        }

        return $result;
    }

    public function getInitalPeriod($type)
    {
        $this->date = new HeadStatisticForm();
        $this->date->department = Yii::$app->user->identity->id_department;
        $this->date->user = 0;
        $currDate = new DateTime;
        $this->date->to = $currDate->format('Y-m-d');
        $currDate->sub(DateInterval::createFromDateString('1 year'));
        $this->date->from = $currDate->format('Y-m-d');;
        $this->date->type = $type;
        $this->date->user = null;
        return $this->date;
    }

}