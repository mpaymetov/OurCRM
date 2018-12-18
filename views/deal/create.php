<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\service\UserService;

/* @var $user app\service\DealService */
/* @var $project app\service\DealService */
/* @var $client app\service\DealService */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="deal-form">
    <?php
    $form = ActiveForm::begin([
        'id' => 'user-update-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?php echo '<div class="form-group"> <label class = "control-label">Создавший</label>
                <div class = "form-control ">' . $user->login . '</div> </div>' ?>
    <h4>Клиент</h4>
    <?= $form->field($client, 'name') ?>
    <?= $form->field($person, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($person, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($person, 'position')->textInput(['maxlength' => true]) ?>
    <?= $form->field($person, 'contact')->textInput(['maxlength' => true]) ?>
    <?= $form->field($person, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($client, 'comment') ?>
    <h4>Проект</h4>
    <?= $form->field($project, 'name') ?>
    <?= $form->field($project, 'comment') ?>

    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>
