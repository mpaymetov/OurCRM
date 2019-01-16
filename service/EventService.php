<?php

namespace app\service;

use Yii;
use app\models\Event;
use app\models\EventSearch;
use app\service\UserServise;
use app\service\StartParamsService;
use yii\helpers\Json;


class EventService
{
    private $startParams;
    private $dataControl;
    private $userService;

    public function __construct()
    {
        $this->setStartParams(new StartParamsService());
        $this->setDataControl(new DataValidateService());
        $this->setUserService(new UserService());
    }

    public function setDataControl($dataControlService)
    {
        $this->dataControl = $dataControlService;
    }

    public function setStartParams($startParamsService)
    {
        $this->startParams = $startParamsService;
    }

    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function getAllEvents()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $dataProvider;
    }

    public function getEventViewData($id)
    {
        $searchModel = new EventSearch();
        $model = $searchModel->findModel($id);
        if ($this->dataControl->checkElemAvailable($model)) {
            return ['model' => $model];
        } else {
            return false;
        }
    }

    public function setEventUpdate($id)
    {
        $search = new EventSearch();
        $model = $search->findModel($id);
        //ajax галочка отдельно обрабатываем
        if ($this->dataControl->checkElemAvailable($model)) {
            try {
                if (\Yii::$app->request->isAjax) {
                    if ($model->is_active == 0) {
                        $model->is_active = 1;
                    } else {
                        $model->is_active = 0;
                    };
                    $model->save();
                    return ("OK");
                }
                if ($model->load(Yii::$app->request->post()) && $this->dataControl($model) && $model->save()) {
                    return ['model' => $model, 'action' => 'redirect'];
                };

                return ['model' => $model, 'action' => 'curr'];
            } catch
            (StaleObjectException $e) {
                throw new StaleObjectException(Yii::t('app', 'Error data version'));
            }
        }
    }

    public function setCreateEvent()
    {
        $model = new Event();
        $user_name = $this->userService->findLoginById(Yii::$app->user->identity->id_user);
        $this->startParams->takeStartParams($model);
        $this->pushData((Yii::$app->request->post()), $model);
        if ($model->save()) {
           return($model);
        }
        return [
            'model' => $model,
            'action' => 'curr',

        'user' => $user_name,
        ];
    }
    public function pushData($data, $model)
    {
        $model->version = 0;
        $model->id_doer = $data['doer'];
        $model->message = $data['message'];
        $model->created = $data['created'];
    }

    public function incVersion($model)
    {

    }
}

