<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.12.2018
 * Time: 15:58
 */

namespace app\service;

use yii;
use app\db_modules\PersonDbQuery;
use yii\data\ArrayDataProvider;


class PersonService
{
    private $PersonQuery;

    private function SetPersonQuery($PersonDbQuerys)
    {
        $this->PersonQuery = $PersonDbQuerys;
    }

    public function __construct()
    {
        $this->SetPersonQuery(new PersonDbQuery());
    }

    public function GetAllPersonList($idClient)
    {
        $arr = $this->PersonQuery->SearchByClient($idClient);
        $result = $arr;
        return $result;
    }


}