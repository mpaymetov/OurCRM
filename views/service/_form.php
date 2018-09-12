<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'is_enable')->textInput() ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>

    <?php
    if ($model->version == '') {
        $model->version = 0;
        echo $form->field($model, 'version')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'version')->textInput(['maxlength' => true, 'readonly' => true]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
