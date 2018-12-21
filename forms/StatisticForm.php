<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 19.12.2018
 * Time: 15:53
 */

namespace app\forms;

use yii;
use yii\base\Model;
use app\forms\DatePeriodForm;


class statisticForm extends DatePeriodForm
{
    public $type;
    public $user;

    private $types = [
        'project',
        'sale',
        'serviceset'
    ];

    public function rules()
    {
        return [
            [['from', 'to'], 'date', 'format' => 'yyyy-mm-dd'],
            [['from', 'to', 'type'], 'required'],
            [['type'], 'typesValidate'],
            [['user'], 'integer'],
            [['user'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => Yii::t('common', 'From'),
            'to' => Yii::t('common', 'To'),
            'user' => Yii::t('common', 'Manager'),
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