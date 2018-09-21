<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 31.08.2018
 * Time: 19:18
 */

namespace app\models;

use yii\validators\NumberValidator;

class ServiceListForm extends \yii\base\Model
{
    public $serviceList;

    public function rules()
    {
        return [
            [['serviceList'], 'required' ],
            [['serviceList'], 'validateServiceList'],
        ];
    }

    public function validateServiceList($serviceList)
    {
        $items = $this->$serviceList['Service'];

        if (!is_array($items)) {
            $items = [];
        }

        foreach ($items as $index => $item) {
            $validator = new NumberValidator();
            $error = null;
            $validator->validate($item, $error);
            if (!empty($error)) {
                $key = $serviceList . '[' . $index . ']';
                $this->addError($key, $error);
            }
        }
    }

    public function loadServiceList()
    {
        if(!(($this->load(\Yii::$app->request->post())) && ($this->validate())))
            {
                $errors = $this->errors;
                return false;
            }
        return true;
    }


    public function getServiceList($id)
    {
        $data = [];
            $arr = $this->serviceList['Service'];
             foreach ($arr as $index => $item)
             {
                 $data[$index] = [
                     'id_serviceset' => $id,
                     'id_service' =>  $item,
                 ];
             }
        return $data;
    }
}