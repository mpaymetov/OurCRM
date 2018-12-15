<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 20.11.2018
 * Time: 19:38
 */

namespace app\service;


use app\db_modules\StatisticDbQuery;
use app\models\StateCheck;
use app\models\DatePeriodForm;



class StatisticService
{
    private $dbQuery;

    private $monthList = ['Месяц отсутсвует', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    public function __construct()
    {
        $this->setDbQuery(new StatisticDbQuery());
    }

    public function setDbQuery($param)
    {
        $this->dbQuery = $param;
    }

    public function getServicesetNumByStateInfo($idUser)
    {
        $query = $this->dbQuery->getServicesetNumByState($idUser);

        if(empty($query)) {
            return null;
        }

        $state = new StateCheck();
        $result = [['state', 'num']];

        foreach ($query as $el)
        {
            $arrEl = [(string)$state->getStateName($el['state']),  (int)$el['num']];
            array_push($result, $arrEl);
        }

        return $result;
    }

    public function getProjectNumByStateForLastYearInfo($idUser)
    {
        $query = $this->dbQuery->getProjectNumberForLastYear($idUser);

        if(empty($query)) {
            return null;
        }



        $result = [['month', 'all', 'close', 'cancellation']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['all'], (int)$el['close'], (int)$el['cancellation']];
            array_push($result, $arrEl);
        }

        return $result;
    }

    public function getProjectNumByStateForPeriod($idUser, $datePeriod)
    {
        $query = $this->dbQuery->getProjectNumberForPeriod($idUser, $datePeriod->from, $datePeriod->to);

        if(empty($query)) {
            return null;
        }

        $result = [['month', 'all', 'close', 'cancellation']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['all'], (int)$el['close'], (int)$el['cancellation']];
            array_push($result, $arrEl);
        }

        return $result;
    }



    public function getSalesForLastYearInfo($idUser)
    {
        $query = $this->dbQuery->getSalesForLastYear($idUser);
        
        if(empty($query)) {
            return null;
        }

        $result = [['month', 'sale']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['sale']];
            array_push($result, $arrEl);
        }

        return $result;
    }

    public function getSalesForLastPeriod($idUser, $datePeriod)
    {
        $query = $this->dbQuery->getSalesForPeriod($idUser, $datePeriod->from, $datePeriod->to);
        
        if(empty($query)) {
            return null;
        }

        $result = [['month', 'sale']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['sale']];
            array_push($result, $arrEl);
        }

        return $result;
    }



    public function getChartInfoByPeriod($idUser, $datePeriod)
    {
        $result = null;
        switch ($datePeriod->type){
            case 'project':
                $result = $this->getProjectNumByStateForPeriod($idUser, $datePeriod);
                break;
            case 'sale':
                $result = $this->getSalesForLastPeriod($idUser, $datePeriod);
                break;
            default:
                return false;
        }

        return $result;
    }

    public function getMonthList($from, $to)
    {
        $firstMonth = date("n", strtotime($from));
        $lastMonth = date("n", strtotime($to));
        $firstYear = date("Y", strtotime($from));
        $lastYear = date("Y", strtotime($to));
        $result = [];
        $list = [];
        $yearDifference = $lastYear - $firstYear;
        if($yearDifference == 0) {
            for($i = $firstMonth; $i <= $lastMonth; $i++) {
                array_push($list, $this->monthList[$i]);
            }
            $result[$firstYear] = $list;
        } elseif ($yearDifference == 1) {
            for($i = $firstMonth; $i <= 12; $i++) {
                array_push($list, $this->monthList[$i]);
            }
            $result[$firstYear] = $list;
            $list = [];
            for($i = 1; $i <= $lastMonth; $i++) {
                array_push($list, $this->monthList[$i]);
            }
            $result[$lastYear] = $list;
        } elseif ($yearDifference > 1) {
            for($i = $firstMonth; $i <= 12; $i++) {
                array_push($list, $this->monthList[$i]);
            }
            $result[$firstYear] = $list;
            $list = [];
            for ($i = 1; $i < $yearDifference; $i ++)
            {
                for ($j = 1; $j <= 12; $j++) {
                    array_push($list, $this->monthList[$i]);
                }
                $result[$firstYear + $i] = $list;
                $list = [];
            }
            for($i = 1; $i <= $lastMonth; $i++) {
                array_push($list, $this->monthList[$i]);
            }
            $result[$lastYear] = $list;
        }
        return $list;
    }

    public function addMonthInfo($query, $columns, $from, $to)
    {
        $list = $this->getMonthList($from, $to);
        $result = [];
        array_push($result, $columns);
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['sale']];
            array_push($result, $arrEl);
        }

        foreach ($query as $year => $arr) {
            foreach ($arr as $month) {

            }
        }

$

}