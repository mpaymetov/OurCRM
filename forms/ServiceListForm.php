<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 31.08.2018
 * Time: 19:18
 */

namespace app\forms;

use Yii;
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

    public function attributeLabels()
    {
        return [
            'serviceList' =>Yii::t('common', 'Service List'),
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
            $validator->integerOnly = true;
            if (!empty($error)) {
                $key = $serviceList . '[' . $index . ']';
                $this->addError($key, $error);
            }
        }
    }
}