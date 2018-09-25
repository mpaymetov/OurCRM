<?php
namespace app\controllers;
class SecurityController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public static function validateParam($model, $model2)
    {
        switch ($model2->id_user) {
            case '':
                return false;
                break;
            case $model->id_user:
                return true;
                break;
            default:
                return false;
        }
    }
    public static function validateEventParam($model, $model2)
    {
        switch ($model2->id_link . $model2->link = null) {
            case '':
                return false;
                break;
            case $model->id_link . $model->link = null:
                return true;
                break;
            default:
                return false;
        }
    }
    public static function validateProjectParam($model, $model2 = null)
    {
        switch ($model2->id_client . $model2->id_user) {
            case '':
                return false;
                break;
            case $model->id_client . $model->id_user:
                return true;
                break;
            default:
                return false;
        }
    }
}