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


$form = ActiveForm::begin(['id' => 'date-period', 'options' =>['class' => 'form-inline ']]);
    echo $form->field($model, 'from')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'options' => ['id' => Html::getInputId($model, 'from').$uniqid],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]);

    echo $form->field($model, 'to')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'options' => ['id' => Html::getInputId($model, 'from').$uniqid],
        'pluginOptions' => [
        'autoclose' => true,
        ]
    ]);

    echo Html::beginTag('div', ['class' => 'form-group']);
        echo Html::submitButton(
            Yii::t('app', Yii::t('common', 'Select')),
            ['class' => 'btn btn-success date-select', 'id' => $uniqid]);
    echo Html::endTag('div');
ActiveForm::end();