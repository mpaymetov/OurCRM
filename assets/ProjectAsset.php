<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 02.10.2018
 * Time: 12:30
 */

namespace app\assets;

use yii\web\AssetBundle;


class ProjectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/projectView.css',
    ];
    public $js = [
        'js/projectView.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
