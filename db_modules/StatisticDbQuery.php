<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 20.11.2018
 * Time: 19:37
 */

namespace app\db_modules;


class statisticDbQuery
{
    public function getServicesetNumByState($idUser)
    {
        $query = (new \yii\db\Query())
            ->select([
                'serviceset.id_state AS state',
                'COUNT(*) AS num'
            ])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->where([
                'project.id_user' => $idUser
            ])
            ->groupBy('serviceset.id_state')
            ->all();

        return $query;
    }



}