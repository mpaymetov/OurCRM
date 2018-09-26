<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->widget(\kartik\datetime\DateTimePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>


    <?= $form->field($model, 'assignment')->widget(\kartik\datetime\DateTimePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>


    <?php
    if ($model->is_active == '') {
        $model->is_active = 1;
        echo $form->field($model, 'is_active')->textInput(['maxlength' => true]);
    } else {
        echo $form->field($model, 'is_active')->textInput(['maxlength' => true]);
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
