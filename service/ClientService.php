<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 07.12.2018
 * Time: 20:27
 */

namespace app\service;

use app\models\Client;
use yii;
use app\db_modules\PersonDbQuery;
use app\models\UserSearch;


class ClientService
{

    public function SaveNewClientAndPerson($client, $person)
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        $result = false;

        try {
            $client->save();
            $person->main = 1;
            $person->id_client = $client->id_client;
            $person->save();
            $transaction->commit();
            $result = true;
        } catch(\Exception $e) {
            $transaction->rollBack();
        }

        return $result;
    }

    public function GetMainPersonInfo($idClient)
    {
        $personSearch = new PersonDbQuery();
        $arr = $personSearch->SearchMainPerson($idClient);
        $info = [];
        if($arr) {
            $info = [
                'id' => $arr[0]['id_person'],
                'first_name' => $arr[0]['first_name'],
                'last_name' => $arr[0]['last_name'],
                'position' => $arr[0]['position'],
                'contact' => $arr[0]['contact'],
                'email' => $arr[0]['email']
            ];
        }


        return $info;
    }

    public function GetManagerList($idDepartment)
    {
        $arr = (new UserSearch())->GetManagerList($idDepartment);
        $keys = [
            'id_user',
            'first_name',
            'second_name'
        ];

        $result = [];

        foreach ($arr as $item) {
            $curr = [];
            foreach ($keys as $key) {
                if(key_exists($key, $item)) {
                    $curr[$key] = $item[$key];
                }
            }
            if($curr) {
                array_push($result, $curr);
            }
        }

        $list = [];
        foreach ($result as $item) {
            $list[(int)$item['id_user']] = $item['first_name'] . ' ' . $item['second_name'];
        }

        return $list;
    }


}