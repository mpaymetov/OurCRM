<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 17.12.2018
 * Time: 19:20
 */

namespace app\service;


class DateService
{
    private $monthList = ['Месяц отсутсвует', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];


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

            for ($i = 1; $i < $yearDifference; $i++)
            {
                for ($j = 1; $j <= 12; $j++) {
                    array_push($list, ['num' => $j, 'month' => $this->monthList[$j], 'year' => $firstYear + $j]);
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
                    ($find) ? (array_push($el, (int)$query[$num][$column])) : (array_push($el, (int)0));
                }
            }

            array_push($result, $el);
            $el = [];
            $find = false;
            $num = -1;
        }
        return $result;
    }
}