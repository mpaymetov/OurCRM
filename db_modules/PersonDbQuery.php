<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.12.2018
 * Time: 15:34
 */

namespace app\db_modules;

use yii\db\Query;

class PersonDbQuery
{
    public function SearchByClient($idClient)
    {
        $query = (new Query())
            ->from('person')
            ->andWhere([
                'id_client' => $idClient
            ])
            ->all();

        return $query;
    }

    public function SearchMainPerson($idClient)
    {
        $query = (new Query())
            ->from('person')
            ->andWhere([
                'id_client' => $idClient,
                'main' => 1
            ])
            ->all();

        return $query;
    }
}