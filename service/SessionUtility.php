<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.11.2018
 * Time: 20:23
 */

namespace app\service;

use Yii;


class SessionUtility
{
    public function GetSessionArray()
    {
        return Yii::$app->session;
    }

    public function SetSessionElem($key, $value)
    {
        Yii::$app->session->set($key, $value);
    }

    public function GetSessionElem($key)
    {
        return Yii::$app->session->get($key);
    }

    public function RemoveSessionElem($key)
    {
        Yii::$app->session->remove($key);
    }
}