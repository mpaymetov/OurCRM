<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 26.11.2018
 * Time: 20:06
 */

namespace app\models;
use yii;
use yii\validators\DateValidator;
use yii\base\Model;


class DatePeriodForm extends Model
{
    public $from;
    public $to;

    public function rules()
    {
        return [
            [['from', 'to'], 'date']
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => Yii::t('common', 'From'),
            'to' => Yii::t('common', 'To  ')
        ];
    }
}