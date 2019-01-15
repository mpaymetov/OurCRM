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
    const MakeContact = 0;
    const IdentifyNeed = 1;
    const Invoicing = 2;
    const Payment = 3;
    const Delivery = 4;
    const Close = 5;
    const Сancellation = 6;

    private $stateList = [
        'Установление контакта',
        'Выявление потребностей',
        'Выставление счета',
        'Оплата',
        'Поставка',
        'Завершено',
        'Отказ'
    ];

   public $currState;

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
    }

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

    public function getActiveStateList()
    {
        $result = [];
        for($i = $this::MakeContact; $i <= $this::Delivery; $i++)
        {
            array_push($result, ['id' => $i, 'name' => $this->stateList[$i]]);
        }
        return $result;
    }
}