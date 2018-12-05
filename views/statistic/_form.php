<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 26.11.2018
 * Time: 21:31
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'action' => ['statistic/render-chart-by-period'],
    'options' =>['class' => 'form-inline date-period-form']
]);

    echo $form->field($model, 'type')->hiddenInput(['value' => $uniqid])->label(false);

    echo $form->field($model, 'from')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'options' => ['id' => Html::getInputId($model, 'from').$uniqid],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);

    echo $form->field($model, 'to')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'options' => ['id' => Html::getInputId($model, 'to').$uniqid],
        'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
    ]);

    echo Html::submitButton(
            Yii::t('app', Yii::t('common', 'Select')),
            ['class' => 'btn btn-success date-select', 'id' => $uniqid]);

ActiveForm::end();