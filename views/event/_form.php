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



    <?php
    if ($model->link != '') {
        echo $form->field($model, 'link')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'link')->textInput(['maxlength' => true]);
    }
    ?>

    <?php
    echo $form->field($model, 'id_link')->textInput(['maxlength' => true]);
    ?>

    <?php
    if ($model->id_user) {
        echo $form->field($model, 'id_user')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'id_user')->textInput(['maxlength' => true]);
    }
    ?>

    <?php
        echo $form->field($model, 'is_active')->textInput(['maxlength' => true]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
