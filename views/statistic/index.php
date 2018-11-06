<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:56
 */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;

echo Html::beginTag('div', ['class' => 'chart']);
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
        'data' => $model,
        'options' => array('title' => 'Chart')));
echo Html::endTag('div');