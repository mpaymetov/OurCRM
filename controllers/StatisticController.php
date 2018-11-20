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
use yii\web\Controller;
use app\service\StatisticService;


class StatisticController extends Controller
{

    private $statisticService;

    public function init()
    {
        $this->getService();
    }

    public function getService()
    {
        $this->statisticService = new StatisticService();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/user/login', 302));
        }


        $model = $this->statisticService->getServicesetNumByStateInfo(Yii::$app->user->identity->id_user);

        return $this->render('index', [
            'model' => $model,
        ]);
    }



}