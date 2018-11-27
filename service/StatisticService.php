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



class StatisticService
{
    private $dbQuery;

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

        $result = [['month', 'all', 'close', 'cancellation']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['num'], (int)$el['close'], (int)$el['cancellation']];
            array_push($result, $arrEl);
        }

        return $result;
    }

    public function getSalesForLastYearInfo($idUser)
    {
        $query = $this->dbQuery->getSalesForLastYear($idUser);
        $result = [['month', 'sale']];
        foreach ($query as $el)
        {
            $arrEl = [$el['month'], (int)$el['cost']];
            array_push($result, $arrEl);
        }

        return $result;
    }


}