<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 27.11.2018
 * Time: 22:13
 */

namespace app\assets;

use yii\web\AssetBundle;

class StatisticAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/statisticView.css',
    ];
    public $js = [
        'js/statisticView.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}