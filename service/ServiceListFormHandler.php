<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 06.11.2018
 * Time: 19:38
 */

namespace app\service;

use app\models\ServiceListForm;


class ServiceListFormHandler
{
    public function loadServiceList()
    {
        $list = new ServiceListForm();

        if(!(($list->load(\Yii::$app->request->post())) && ($list->validate())))
        {
            $errors = $list->errors;
            return false;
        }
        return true;
    }


    public function getServiceList($id, $list)
    {
        $data = [];
        $arr = $list->serviceList['Service'];
        $i = 0;
        $num = count($arr);
        foreach ($arr as $item)
        {
            $data[$i] = [
                'id_serviceset' => $id,
                'id_service' =>  $item,
            ];
            $i++;
        }
        return $data;
    }

}