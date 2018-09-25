<?php

namespace app\controllers;

class SecurityController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public static function validateParam1($model, $model2)
    {
        if ($model2->id_user == $model->id_user) {
            print_r("in if");
            if (property_exists($model, 'id_link')) {
                if (($model2->id_link . $model2->link != null) && ($model2->id_link . $model2->link == $model->id_link . $model->link)) {
                    return true;
                }
            } elseif (property_exists($model, 'id_client')) {
                if (($model2->id_client != null) && ($model2->id_client == $model->id_client)) {
                    return true;
                }
            } else {
                print_r("wrong");
                return false;
            }
        }
    }

}