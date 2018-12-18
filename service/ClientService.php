<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 07.12.2018
 * Time: 20:27
 */

namespace app\service;


use app\models\ClientSearch;
use yii;
use app\db_modules\PersonDbQuery;
use yii\helpers\ArrayHelper;


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


    public function GetClientList($idUser)
    {
        $arr = (new ClientSearch())->searchClientList($idUser);
        $result = ArrayHelper::map($arr, 'id_client', 'name');
        return $result;
    }

}