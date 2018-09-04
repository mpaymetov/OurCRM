<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\Serviceset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if($model->id_project) {
       echo $form->field($model, 'id_project')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
       echo $form->field($model, 'id_project')->textInput(['maxlength' => true]);
    }
    ?>

    <?= $form->field($model, 'id_state')->dropDownList($itemsState)?>

    <?= $form->field($model, 'delivery')->widget(\kartik\datetime\DateTimePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'payment')->widget(\kartik\datetime\DateTimePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
