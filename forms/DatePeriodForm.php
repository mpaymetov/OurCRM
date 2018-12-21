<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 26.11.2018
 * Time: 20:06
 */

namespace app\forms;
use yii;
use yii\validators\DateValidator;
use yii\base\Model;


class DatePeriodForm extends Model
{
    public $from;
    public $to;

    public function rules()
    {
        return [];
    }

    public function dateCheck()
    {
        return ($this->from <= $this->to);
    }

}