<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 06.10.2018
 * Time: 19:53
 */

namespace app\models;

use  yii\base\Model;
use yii\validators\NumberValidator;


class StateCheck extends Model
{
    const MakeContact = 1;
    const IdentifyNeed = 2;
    const Invoicing = 3;
    const Payment = 4;
    const Delivery = 5;
    const Close = 6;
    const Сancellation = 7;

    /*private $stateList = [
        'Установление контакта',
        'Выявление потребностей',
        'Выставление счета',
        'Оплата',
        'Поставка',
        'Завершено',
        'Отказ'
    ];

   /* public $currState;

    public function rules()
    {
        return [
            [['currState'], 'required' ],
            [['currState'], 'integer' ],
            [['currState'], 'ValidateState'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'currState' =>Yii::t('common', 'State'),
        ];
    }*/

    public function ValidateState($id_state)
    {
        $validator = new NumberValidator();
        $validator->integerOnly = true;
        $error = null;
        if((!$validator->validate($id_state, $error)) && (($id_state < 0) || ($id_state >= count($this->stateList))))
        {
           return false;
        }
        return true;
    }

    public function getStateName($id_state)
    {
        $name = null;
        if ($this->ValidateState($id_state)){
            $name = $this->stateList[$id_state];
        }

        return $name;
    }


    public function getStateList()
    {
        return $this->stateList;
    }
}