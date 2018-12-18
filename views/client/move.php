<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 18.12.2018
 * Time: 15:38
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


echo Html::beginTag('div', ['class' => 'client-move-form']);
    $form = ActiveForm::begin();
        echo $form->field($clientMove, 'idClient')->dropDownList($clientList, ['readonly' => 'true']);
        echo $form->field($clientMove, 'idManager')->dropDownList($managerList, ['prompt' => 'Укажите менеджера']);
        echo Html::a(Yii::t('common', 'Back'), Yii::$app->request->getReferrer(), ['class' => 'btn btn-success']);
        echo Html::submitButton(Yii::t('common', 'Move'), ['class' => 'btn btn-success']);
    ActiveForm::end();
echo Html::endTag('div');
