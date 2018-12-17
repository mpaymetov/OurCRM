<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 20.11.2018
 * Time: 19:38
 */

namespace app\service;


use Yii;
use app\db_modules\StatisticDbQuery;
use app\models\StateCheck;
use app\forms\DatePeriodForm;
use DateInterval;
use DateTime;


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

    public function getServicesetNumByStateInfo($datePeriod)
    {
        $query = $this->dbQuery->getServicesetNumByState($datePeriod->user);

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

    public function getProjectNumByStateForLastYearInfo($idUser)
    {
        $query = $this->dbQuery->getProjectNumberForLastYear($idUser);

        $result = [['month', 'all', 'close', 'cancellation']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['all'], (int)$el['close'], (int)$el['cancellation']];
            array_push($result, $arrEl);
        }

        return $result;
    }

    public function getProjectNumByStateForPeriod($datePeriod)
    {
        $query = $this->dbQuery->getProjectNumberForPeriod($datePeriod->user, $datePeriod->from, $datePeriod->to);

        $columns = ['month', 'all', 'close', 'cancellation'];

        $result = $this->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;
    }

    public function getSalesForLastPeriod($datePeriod)
    {
        $query = $this->dbQuery->getSalesForPeriod($datePeriod->user, $datePeriod->from, $datePeriod->to);

        $columns = ['month', 'sale'];

        $result = $this->addMonthInfo($query, $columns, $datePeriod->from, $datePeriod->to);

        return $result;
    }



    public function getChartInfoByPeriod($datePeriod)
    {
        $result = null;
        switch ($datePeriod->type){
            case 'project':
                $result = $this->getProjectNumByStateForPeriod($datePeriod);
                break;
            case 'sale':
                $result = $this->getSalesForLastPeriod($datePeriod);
                break;
            case 'serviceset':
                $result = $this->getServicesetNumByStateInfo($datePeriod);
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
        $list = [];
        $yearDifference = $lastYear - $firstYear;
        if($yearDifference == 0) {
            for($i = $firstMonth; $i <= $lastMonth; $i++) {
                array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $firstYear]);
            }
        } elseif ($yearDifference == 1) {
            for($i = $firstMonth; $i <= 12; $i++) {
                array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $firstYear]);
            }

            for($i = 1; $i <= $lastMonth; $i++) {
                array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $lastYear]);
            }

        } elseif ($yearDifference > 1) {
            for($i = $firstMonth; $i <= 12; $i++) {
                array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $firstYear]);
            }

            for ($i = 1; $i < $yearDifference; $i ++)
            {
                for ($j = 1; $j <= 12; $j++) {
                    array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $firstYear + $j]);
                }
            }
            for($i = 1; $i <= $lastMonth; $i++) {
                array_push($list, ['num' => $i, 'month' => $this->monthList[$i], 'year' => $lastYear]);
            }
        }
        return $list;
    }

    public function addMonthInfo($query, $columns, $from, $to)
    {
        $list = $this->getMonthList($from, $to);

        $result = [];
        array_push($result, $columns);

        $el = [];
        $find = false;
        $num = -1;

        foreach ($list as $item) {
            foreach ($query as $str) {
                $find = (($str['month'] == $item['num']) && ($str['year'] == $item['year']));
                $num++;
                if ($find) {
                    break;
                }
            }

            foreach ($columns as $column) {
                if ($column == 'month') {
                    array_push($el, $item[$column]);
                } else {
                    ($find) ? (array_push($el, $query[$num][$column])) : (array_push($el, (int)0));
                }
            }

            array_push($result, $el);
            $el = [];
            $find = false;
            $num = -1;
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
        $date->user = Yii::$app->user->identity->id_user;
        return $date;
    }

}