<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20.12.2018
 * Time: 15:12
 */

namespace app\service;
use app\db_modules\servisetDbQuery;
use app\models\StateCheck;
use yii\data\ArrayDataProvider;
use Yii;
use app\api\models\MainDTO;

class MainService
{
    public function getMainItems()
    {
        $searchModel = new servisetDbQuery();
        $state = new StateCheck();
        $list = $state->getStateList();
        $dataProvider = [];
        $item = [];
        for ($i_state = $state::MakeContact; $i_state <= $state::Close; $i_state++) {
            $item['state'] = $list[$i_state];
            $item['info'] = new ArrayDataProvider([
                'allModels' => $searchModel->getServiceSetInfoByStateAndUser($i_state, Yii::$app->user->identity->id_user)
            ]);
            $dataProvider[] = $item;
        }

        return $dataProvider;
    }
}