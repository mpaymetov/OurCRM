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
    public $type;

    private $types = [
        'project',
        'sale'
    ];

    public function rules()
    {
        return [
            [['from', 'to'], 'date', 'format' => 'yyyy-mm-dd'],
            [['from', 'to', 'type'], 'required'],
            [['type'], 'typesValidate']
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => Yii::t('common', 'From'),
            'to' => Yii::t('common', 'To  ')
        ];
    }

    public function typesValidate($type)
    {
        $result = false;

        foreach ($this->types as $el)
        {
            $result = ($result || ($type == $el));
        }

        return $result;
    }
}