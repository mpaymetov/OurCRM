<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_event') ?>

    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'assignment') ?>

    <?= $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'id_link') ?>

    <?php // echo $form->field($model, 'id_manager') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
