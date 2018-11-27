<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 26.11.2018
 * Time: 20:06
 */

namespace app\models;


class DatePeriodForm extends \yii\base\Model
{
    public $from;
    public $to;

    public function rules()
    {
        return [
            [['from', 'to'], 'date'],
            [['from', 'to'], 'require']
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => Yii::t('common', 'From'),
            'to' => Yii::t('common', 'From')
        ];
    }
}