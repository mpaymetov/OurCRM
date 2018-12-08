<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelPerson, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelPerson, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelPerson, 'position')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelPerson, 'contact')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelPerson, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>


    <?= Html::activeHiddenInput($model, 'version'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
