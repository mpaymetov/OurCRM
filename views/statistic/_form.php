<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 26.11.2018
 * Time: 21:31
 */

use yii\helpers\Html;

echo Html::beginForm($action = '', $method = 'post', $options = ['id' => 'date-period']);
    echo Html::input('text', 'from', null ,['class' => 'username']);

echo Html::endForm();