<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_admin')->textInput() ?>

    <?= $form->field($model, 'user_read_all')->textInput() ?>

    <?= $form->field($model, 'user_self_dep')->textInput() ?>

    <?= $form->field($model, 'user_create')->textInput() ?>

    <?= $form->field($model, 'client_read_all')->textInput() ?>

    <?= $form->field($model, 'client_create')->textInput() ?>

    <?= $form->field($model, 'project_read_all')->textInput() ?>

    <?= $form->field($model, 'project_create')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
