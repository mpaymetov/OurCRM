<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:56
 */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;
use app\assets\StatisticAsset;
use yii\web\View;


StatisticAsset::register($this);
echo Html::beginTag('div', ['class' => 'info']);

echo Html::endTag('div');

echo Html::tag('h3', \Yii::t('common', 'Project distribution'), ['class' => 'chart-name']);

echo Html::beginTag('div', ['class' => 'serviceset', 'id' => 'serviceset-num']);
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
        'data' => $serviceset,
        'options' => array('')));
echo Html::endTag('div');


echo Html::tag('h3', \Yii::t('common', 'Close project distribution'), ['class' => 'chart-name']);


echo Html::beginTag('div', ['class' => 'project', 'id' => 'project-chart']);

    echo $this->render(
        '_form',
        ['model' => $dateModelProject, 'uniqid' => 'project']
    );
    echo Html::beginTag('div', ['class' => 'project', 'id' => 'project-num']);
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
        'data' => $project,
        'options' => array()));
    echo Html::endTag('div');
echo Html::endTag('div');

echo Html::tag('h3', \Yii::t('common', 'Sale distribution'), ['class' => 'chart-name']);

echo Html::beginTag('div', ['class' => 'sale', 'id' => 'sale-chart']);

echo $this->render(
        '_form',
        ['model' => $dateModelSale, 'uniqid' => 'sale']
    );

    echo Html::beginTag('div', ['class' => 'sale', 'id' => 'sale-num']);
    echo GoogleChart::widget(array('visualization' => 'LineChart',
        'data' => $sale,
        'options' => array()));
    echo Html::endTag('div');
echo Html::endTag('div');

//$this->registerJsFile('https://www.gstatic.com/charts/loader.js',['position' => View::POS_HEAD]);