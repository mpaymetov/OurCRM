<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $user app\models\User */
/* @var $project app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="deal-form">
    <?php
    $form = ActiveForm::begin([
        'id' => 'user-update-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($user, 'id_user') ?>

    <?= $form->field($client, 'name') ?>
    <?= $form->field($client, 'comment') ?>


    <?= $form->field($project, 'name') ?>
    <?= $form->field($project, 'comment') ?>

    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>
