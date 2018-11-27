<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:56
 */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;

echo Html::beginTag('div', ['class' => 'info']);

echo Html::endTag('div');

echo Html::tag('h3', \Yii::t('common', 'Project distribution'), ['class' => 'chart-name']);

echo Html::beginTag('div', ['class' => 'serviceset', 'id' => 'serviceset-num']);
    echo $this->render(
        '_form'
    );

    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
        'data' => $serviceset,
        'options' => array('')));
echo Html::endTag('div');

echo Html::tag('h3', \Yii::t('common', 'Close project distribution'), ['class' => 'chart-name']);
echo Html::beginTag('div', ['class' => 'project', 'id' => 'project-num']);
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
        'data' => $project,
        'options' => array()));

echo Html::tag('h3', \Yii::t('common', 'Sale distribution'), ['class' => 'chart-name']);
echo Html::endTag('div');echo Html::beginTag('div', ['class' => 'sale', 'id' => 'sale-num']);
    echo GoogleChart::widget(array('visualization' => 'LineChart',
        'data' => $sale,
        'options' => array()));
echo Html::endTag('div');