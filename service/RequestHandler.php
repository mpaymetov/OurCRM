<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 11.11.2018
 * Time: 20:03
 */

namespace app\service;

use Yii;


class RequestHandler
{
    public function getReferrerAddress()
    {
        return Yii::$app->request->getReferrer();
    }


}