<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:56
 */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;

//var_dump($model);

echo GoogleChart::widget(array('visualization' => 'ColumnChart',
    'data' => $model,
    'options' => array('title' => 'Chart')));