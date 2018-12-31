<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 25.12.2018
 * Time: 21:25
 */

namespace app\service;

use yii;
use yii\helpers\ArrayHelper;


class ReferrerHandler
{

    public function checkLastPage($pathRefer, $pathCurr, $address) //todo перенести в валидатор
    {
        $gettingId = $this->getReferrerId($address);

        return ((($this->checkPage($address, $pathRefer)) && ($gettingId != NULL)) || ($this->checkPage($address, $pathCurr)));
    }

    public function getReferrerId($str) //todo перенести в referer handler
    {
        $result = NULL;
        parse_str($str, $el);
        if (ArrayHelper::keyExists('id', $el)) {
            $result = (integer)$el['id'];
        }
        return $result;
    }

    public function checkPage($str, $path)
    {
        $query = parse_url($str, PHP_URL_QUERY);
        parse_str($query, $el);
        if (ArrayHelper::keyExists('r', $el)) {
            return ($el['r'] === $path);
        }
        return false;
    }

    public function checkGetString($str, $key)
    {
        //проверить есть ли в $str выражение вида ' $key.-. цифра '
        $reg = '/' . $key . '-[0-9]{1,}/';
        return preg_match($reg, $str, $result);
    }

    public function getIdFromStringByKey($str, $key)
    {
        //найти в $str из выражение вида ' $key.-. цифра ' цифру
        $arr = explode(' ', $str);
        $reg = '/' . $key . '-[0-9]{1,}/';
        $id = null;
        $counter = 0;
        foreach ($arr as $el) {
            if (preg_match($reg, $el, $findEl)) {
                preg_match('/[0-9]{1,}/', $findEl[0], $result);
                $id = $result[0];
                $counter++;
            }
        }

        if ($counter != 1) {
            $id = null;
        }

        return $id;
    }


}