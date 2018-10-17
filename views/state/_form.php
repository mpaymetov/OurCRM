<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StateCheck */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="state-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'version'); ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    if ($model->version == '') {
        $model->version = 0;
        echo $form->field($model, 'version')->textInput(['maxlength' => true, 'readonly' => true]);
    } else {
        echo $form->field($model, 'version')->textInput(['maxlength' => true, 'readonly' => true]);
    }
    ?>
    <?php ActiveForm::end(); ?>

</div>
