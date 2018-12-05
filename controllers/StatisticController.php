<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 30.10.2018
 * Time: 19:37
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\DatePeriodForm;
use yii\web\Controller;
use app\service\StatisticService;
use app\db_modules\StatisticDbQuery;
use app\service\RequestHandler;
use yii\bootstrap\ActiveForm;
use yii\web\Response;



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

        $dateModelProject = new DatePeriodForm();
        $dateModelSale= new DatePeriodForm();
        $serviceset = $this->statisticService->getServicesetNumByStateInfo(Yii::$app->user->identity->id_user);
        $project = $this->statisticService->getProjectNumByStateForLastYearInfo(Yii::$app->user->identity->id_user);
        $sale = $this->statisticService->getSalesForLastYearInfo(Yii::$app->user->identity->id_user);



        return $this->render('index', [
            'serviceset' => $serviceset,
            'project'=>$project,
            'sale'=>$sale,
            'dateModelProject'=>$dateModelProject,
            'dateModelSale'=>$dateModelSale
        ]);
    }

    public function actionRenderChartByPeriod()
    {
        $dateModel = new DatePeriodForm();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];

        if ((Yii::$app->request->isAjax)&&($dateModel->load(\Yii::$app->request->post()))){
           if($dateModel->validate()) {
                $response['info'] = $this->statisticService->getChartInfoByPeriod(Yii::$app->user->identity->id_user, $dateModel);
                $response['type'] = $dateModel->type;
                if ($response['info'] != null)
                {
                    $response['success'] = 'success';
                    $response['error'] = null;
                } else {
                    $response['success'] = null;
                    $response['error'] = 'error';
                }
           } else {
               return ActiveForm::validate($dateModel);
           }
        }

        return $response;
    }

}