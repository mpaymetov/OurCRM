<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:37
 */

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\StateCheck;


class StatisticController extends SecurityController
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }


        $model = $this->getServicesetNumByState(Yii::$app->user->identity->id_user);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    private function getServicesetNumByState($idUser)
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

        $state = new StateCheck();
        $result = [['state', 'num']];

        foreach ($query as $el)
        {
            $arrEl = [(string)$state->getStateName($el['state']),  (int)$el['num']];
            array_push($result, $arrEl);
        }

        return $result;
    }

}