<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 04.11.2018
 * Time: 21:25
 */

namespace app\db_modules;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Serviceset;
use app\models\StateCheck;


class servisetDbQuery
{

    public function getServiceSetInfoByProjectId($id)
    {
        $data = (new \yii\db\Query())
            ->select(['id_serviceset AS id', 'id_state', 'delivery', 'payment', 'is_open', 'creation_date', 'prev_state', 'close_date', 'id_project'])
            ->from('serviceset')
            ->where('id_project=:id_project', [':id_project' => $id])
            ->all();


        /*$state = new StateCheck();
        $data['list'] = $state->getStateList();
        /*foreach ($data as &$item) {
            $i = $item['state'];
            $item['state'] =['id_state' => $i, 'name' => $state->getStateName($i)];
            $item['list'] = $state->getStateList();
        } */

        return $data;
    }

    public function getServiceSetInfoByStateAndUser($idState, $idUser)
    {
        $data = (new \yii\db\Query())
            ->select(['project.id_project AS id',
                'client.name AS client',
                'project.name AS project_name',
                'serviceset.payment AS payment_date',
                'SUM(service.cost) AS cost',
                'project.comment AS comment'])
            ->from('serviceset')
            ->leftJoin('project', 'project.id_project=serviceset.id_project')
            ->leftJoin('servicelist', 'servicelist.id_serviceset=serviceset.id_serviceset')
            ->leftJoin('service', 'service.id_service=servicelist.id_service')
            ->leftJoin('client', 'client.id_client=project.id_client')
            ->where([
                'project.id_user' => $idUser,
                'serviceset.id_state' => $idState,
            ])
            ->groupBy('serviceset.id_serviceset')
            ->all();
        return $data;
    }

    public function getServiceSetInfo($id)
    {
        $data = (new \yii\db\Query())
            ->select(['servicelist.id_service AS id',
                'service.name AS name',
                'service.cost AS cost',
                ])
            ->from('servicelist')
            ->leftJoin('service', 'service.id_service = servicelist.id_service')
            ->where(['servicelist.id_serviceset' => $id])
             ->all();

        return $data;
    }

}