<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 21.11.2018
 * Time: 10:05
 */

namespace app\service;

use app\db_modules\HeadStatisticDbQuery;


class HeadStatisticService
{
    private $dbQuery;

    public function __construct()
    {
        $this->setDbQuery(new HeadStatisticDbQuery());
    }

    public function setDbQuery($param)
    {
        $this->dbQuery = $param;
    }
}