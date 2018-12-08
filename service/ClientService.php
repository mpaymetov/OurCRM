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
use app\models\Person_x_client;
use app\db_modules\PersonDbQuery;


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
            $person->save();
            $modelPxC = new Person_x_client();
            $modelPxC->id_person = $person->id_person;
            $modelPxC->id_client = $client->id_client;
            $modelPxC->save();
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

}