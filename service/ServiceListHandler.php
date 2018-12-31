<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 25.12.2018
 * Time: 21:09
 */

namespace app\service;

use yii;
use yii\helpers\ArrayHelper;
use app\models\Servicelist;
use app\db_modules\ServisetDbQuery;


class ServiceListHandler
{
    public function updateServiceListArray($arrData, $arrModel)
    {

        $num = min(count($arrData), count($arrModel));

        if ($num != 0) {
            for ($i = 0; $i < $num; $i++) {
                $arrModel[$i]->saveServiceList($arrData[$i]);
            }
        }

        if (count($arrData) > count($arrModel)) {
            for ($i = $num; $i < count($arrData); $i++) {
                $model = new Servicelist();
                $model->saveServiceList($arrData[$i]);
            }
        }

        for ($i = $num; $i < count($arrModel); $i++) {
            $arrModel[$i]->delete();
        }
    }


    public function saveServiceList($data, $model)
    {
        if(!(ArrayHelper::keyExists('id_serviceset', $data) && ArrayHelper::keyExists('id_service', $data))) {
            return false;
        }

        $model->id_serviceset = $data['id_serviceset'];
        $model->id_service = $data['id_service'];
        return $model->save();
    }

    public function saveServiceListArray($arr)
    {
        $result = true;

        foreach ($arr as $item) {
            $model = new Servicelist();
            $result = $result && ($this->saveServiceList($item, $model));
            //var_dump($model);
        }

        return $result;
    }


    public function findServiceList($id)
    {
        $serviceListInfo = new servisetDbQuery();
        $setInfo = $serviceListInfo->getServiceSetInfo($id);
        $arr = [];
        for ($i = 0; $i < count($setInfo); $i++) {
            $arr[$i] = ['Service' => $setInfo[$i]['id']];
        }
        return $arr;
    }

}