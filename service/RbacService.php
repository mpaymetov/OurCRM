<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.12.2018
 * Time: 18:59
 */

namespace app\service;

use Yii;
use yii\data\ArrayDataProvider;

class RbacService
{
    public function getRoleList()
    {
        $roles = Yii::$app->authManager->getRoles();
        $roleArr = [];
        foreach ($roles as $key => $value) {
            $roleArr[$key] = $key;
        }
        return $roleArr;
    }
}