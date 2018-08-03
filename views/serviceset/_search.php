<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServicesetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceset-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_serviceset') ?>

    <?= $form->field($model, 'id_project') ?>

    <?= $form->field($model, 'id_state') ?>

    <?= $form->field($model, 'delivery') ?>

    <?= $form->field($model, 'payment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
